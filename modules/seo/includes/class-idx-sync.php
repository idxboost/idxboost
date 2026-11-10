<?php
defined( 'ABSPATH' ) || exit;

/**
 * Pulls active listings from the IDX service into a local table so sitemaps never hit the API on a bot request.
 *
 * Source:
 *  - filter `idxb_seo_idx_fetch_page` ( null, int $page, array $idx_settings ) → [ 'items' => [ [url, lastmod, images] ], 'has_more' => bool ]
 *    (use it to plug the real IDXBoost service from code), or
 *  - the JSON endpoint configured in the admin (field mapping).
 */
class IDXB_SEO_IDX_Sync {

	const STATE_OPTION = 'idxb_seo_idx_state';
	const CRON_START   = 'idxb_seo_idx_sync';
	const CRON_BATCH   = 'idxb_seo_idx_sync_batch';
	const DB_VERSION   = '1';
	const BATCH_SECONDS = 20;

	public static function init() {
		add_action( self::CRON_START, array( __CLASS__, 'start' ) );
		add_action( self::CRON_BATCH, array( __CLASS__, 'run_batch' ) );
		add_action( 'plugins_loaded', array( __CLASS__, 'maybe_install' ) );
	}

	public static function table(): string {
		global $wpdb;
		return $wpdb->prefix . 'idxb_seo_listings';
	}

	public static function table_exists(): bool {
		global $wpdb;
		return get_option( 'idxb_seo_db_ver' ) === self::DB_VERSION
			|| self::table() === $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', self::table() ) );
	}

	public static function maybe_install() {
		if ( get_option( 'idxb_seo_db_ver' ) !== self::DB_VERSION ) {
			self::install_table();
		}
	}

	public static function install_table() {
		global $wpdb;
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$table   = self::table();
		$charset = $wpdb->get_charset_collate();
		dbDelta(
			"CREATE TABLE {$table} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			listing_key varchar(191) NOT NULL,
			url text NOT NULL,
			lastmod datetime NOT NULL,
			images text NULL,
			sync_id varchar(40) NOT NULL,
			PRIMARY KEY  (id),
			UNIQUE KEY listing_key (listing_key),
			KEY lastmod (lastmod),
			KEY sync_id (sync_id)
			) {$charset};"
		);
		update_option( 'idxb_seo_db_ver', self::DB_VERSION );
	}

	/* ---------- scheduling ---------- */

	public static function reschedule() {
		$settings = IDXB_SEO_Settings::get();
		$next     = wp_next_scheduled( self::CRON_START );
		$want     = $settings['idx']['enabled'] ? $settings['idx']['schedule'] : '';
		$current  = $next ? wp_get_schedule( self::CRON_START ) : '';
		if ( $current === $want ) {
			return;
		}
		wp_clear_scheduled_hook( self::CRON_START );
		if ( $want ) {
			wp_schedule_event( time() + MINUTE_IN_SECONDS, $want, self::CRON_START );
		}
	}

	public static function unschedule() {
		wp_clear_scheduled_hook( self::CRON_START );
		wp_clear_scheduled_hook( self::CRON_BATCH );
	}

	/* ---------- state ---------- */

	public static function state(): array {
		$s = get_option( self::STATE_OPTION, array() );
		return wp_parse_args(
			is_array( $s ) ? $s : array(),
			array(
				'status'       => 'idle',
				'sync_id'      => '',
				'page'         => 1,
				'fetched'      => 0,
				'started'      => 0,
				'finished'     => 0,
				'last_success' => 0,
				'last_count'   => 0,
				'last_error'   => '',
			)
		);
	}

	private static function save_state( array $s ) {
		update_option( self::STATE_OPTION, $s, false );
	}

	public static function status(): array {
		global $wpdb;
		$s          = self::state();
		$s['total'] = self::table_exists() ? (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . self::table() ) : 0; // phpcs:ignore
		$s['next']  = (int) wp_next_scheduled( self::CRON_START );
		return $s;
	}

	/* ---------- sync ---------- */

	public static function start(): array {
		$settings = IDXB_SEO_Settings::get();
		if ( ! $settings['idx']['enabled'] ) {
			return self::status();
		}
		$s = self::state();
		if ( 'running' === $s['status'] && time() - (int) $s['started'] < 2 * HOUR_IN_SECONDS ) {
			return self::status(); // already in progress
		}
		self::maybe_install();
		$s['status']     = 'running';
		$s['sync_id']    = substr( md5( uniqid( '', true ) ), 0, 16 );
		$s['page']       = 1;
		$s['fetched']    = 0;
		$s['started']    = time();
		$s['finished']   = 0;
		$s['last_error'] = '';
		self::save_state( $s );
		self::run_batch();
		return self::status();
	}

	public static function run_batch() {
		$s = self::state();
		if ( 'running' !== $s['status'] ) {
			return;
		}
		$settings = IDXB_SEO_Settings::get();
		$idx      = $settings['idx'];
		$t0       = microtime( true );

		while ( true ) {
			$res = self::fetch_page( $idx, (int) $s['page'] );
			if ( is_wp_error( $res ) ) {
				$s['status']     = 'error';
				$s['last_error'] = sprintf( __( 'Page %1$d: %2$s', 'idxboost-seo' ), $s['page'], $res->get_error_message() );
				$s['finished']   = time();
				self::save_state( $s );
				return; // keep previous listings untouched
			}
			self::store( $res['items'], $s['sync_id'] );
			$s['fetched'] += count( $res['items'] );

			$done = ! $res['has_more'] || $s['page'] >= $idx['maxPages'];
			if ( $done ) {
				self::finish( $s );
				return;
			}
			$s['page']++;
			self::save_state( $s );

			if ( microtime( true ) - $t0 > self::BATCH_SECONDS ) {
				wp_schedule_single_event( time() + 5, self::CRON_BATCH );
				return;
			}
		}
	}

	private static function finish( array $s ) {
		global $wpdb;
		$table = self::table();
		$prev  = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table}" ); // phpcs:ignore
		if ( 0 === (int) $s['fetched'] && $prev > 0 ) {
			// An empty answer from the service is far more likely an outage than "no listings": keep the old data.
			$s['status']     = 'error';
			$s['last_error'] = __( 'The service returned 0 properties; the previous ones were kept.', 'idxboost-seo' );
			$s['finished']   = time();
			self::save_state( $s );
			return;
		}
		$wpdb->query( $wpdb->prepare( "DELETE FROM {$table} WHERE sync_id <> %s", $s['sync_id'] ) ); // phpcs:ignore
		$s['status']       = 'idle';
		$s['finished']     = time();
		$s['last_success'] = time();
		$s['last_count']   = (int) $s['fetched'];
		self::save_state( $s );
		IDXB_SEO_Cache::bump();
	}

	private static function store( array $items, string $sync_id ) {
		global $wpdb;
		$table = self::table();
		foreach ( $items as $it ) {
			$key = substr( (string) $it['key'], 0, 191 );
			$row = array(
				'url'     => $it['url'],
				'lastmod' => gmdate( 'Y-m-d H:i:s', (int) $it['lastmod'] ),
				'images'  => $it['images'] ? wp_json_encode( array_values( $it['images'] ) ) : null,
				'sync_id' => $sync_id,
			);
			$id = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM {$table} WHERE listing_key = %s", $key ) ); // phpcs:ignore
			if ( $id ) {
				$wpdb->update( $table, $row, array( 'id' => (int) $id ) );
			} else {
				$wpdb->insert( $table, $row + array( 'listing_key' => $key ) );
			}
		}
	}

	/* ---------- fetching + mapping ---------- */

	/** @return array|WP_Error [ 'items' => normalized[], 'has_more' => bool ] */
	public static function fetch_page( array $idx, int $page ) {
		$custom = apply_filters( 'idxb_seo_idx_fetch_page', null, $page, $idx );
		if ( is_wp_error( $custom ) ) {
			return $custom;
		}
		if ( is_array( $custom ) ) {
			$items = array();
			foreach ( (array) ( $custom['items'] ?? array() ) as $raw ) {
				$n = self::normalize( (array) $raw, $idx, true );
				if ( $n ) {
					$items[] = $n;
				}
			}
			return array( 'items' => $items, 'has_more' => ! empty( $custom['has_more'] ) );
		}

		if ( empty( $idx['endpoint'] ) ) {
			return new WP_Error( 'idxb_no_endpoint', __( 'No endpoint configured for the IDX service.', 'idxboost-seo' ) );
		}
		$url = $idx['endpoint'];
		if ( str_contains( $url, '{page}' ) || str_contains( $url, '{per_page}' ) ) {
			$url = str_replace( array( '{page}', '{per_page}' ), array( (string) $page, (string) $idx['perPage'] ), $url );
		} else {
			$url = add_query_arg( array( 'page' => $page, 'per_page' => $idx['perPage'] ), $url );
		}
		$headers = array( 'Accept' => 'application/json' );
		if ( $idx['authHeader'] && str_contains( $idx['authHeader'], ':' ) ) {
			list( $hn, $hv )      = array_map( 'trim', explode( ':', $idx['authHeader'], 2 ) );
			$headers[ $hn ]       = $hv;
		}
		$res = wp_remote_get( $url, array( 'timeout' => 30, 'headers' => $headers ) );
		if ( is_wp_error( $res ) ) {
			return $res;
		}
		$code = (int) wp_remote_retrieve_response_code( $res );
		if ( $code < 200 || $code >= 300 ) {
			return new WP_Error( 'idxb_http', sprintf( __( 'HTTP %d from the IDX service.', 'idxboost-seo' ), $code ) );
		}
		$json = json_decode( (string) wp_remote_retrieve_body( $res ), true );
		if ( ! is_array( $json ) ) {
			return new WP_Error( 'idxb_json', __( 'The IDX service response is not valid JSON.', 'idxboost-seo' ) );
		}
		$raw_items = '' === $idx['itemsPath'] ? $json : self::path_get( $json, $idx['itemsPath'] );
		if ( ! is_array( $raw_items ) ) {
			return new WP_Error( 'idxb_items', sprintf( __( 'Property list not found at "%s".', 'idxboost-seo' ), $idx['itemsPath'] ) );
		}
		$items = array();
		foreach ( $raw_items as $raw ) {
			$n = is_array( $raw ) ? self::normalize( $raw, $idx, false ) : null;
			if ( $n ) {
				$items[] = $n;
			}
		}
		return array( 'items' => $items, 'has_more' => count( $raw_items ) >= $idx['perPage'] );
	}

	public static function path_get( $data, string $path ) {
		foreach ( explode( '.', $path ) as $k ) {
			if ( '' === $k ) {
				continue;
			}
			if ( ! is_array( $data ) || ! array_key_exists( $k, $data ) ) {
				return null;
			}
			$data = $data[ $k ];
		}
		return $data;
	}

	/**
	 * Raw item → [ key, url, lastmod, images ] or null.
	 * $prenormalized items (from the filter) may already carry url/lastmod/images.
	 */
	public static function normalize( array $raw, array $idx, bool $prenormalized ): ?array {
		$url = '';
		if ( $prenormalized && ! empty( $raw['url'] ) ) {
			$url = (string) $raw['url'];
		} elseif ( $idx['urlField'] ) {
			$url = (string) self::path_get( $raw, $idx['urlField'] );
		}
		if ( '' === $url ) {
			$slug = $idx['slugField'] ? self::path_get( $raw, $idx['slugField'] ) : null;
			$tpl  = $idx['urlTemplate'];
			$url  = preg_replace_callback(
				'/\{([A-Za-z0-9_.\-]+)\}/',
				function ( $m ) use ( $raw, $slug ) {
					$v = 'slug' === $m[1] ? $slug : self::path_get( $raw, $m[1] );
					return is_scalar( $v ) ? rawurlencode( sanitize_title( (string) $v ) ) : '';
				},
				$tpl
			);
			if ( str_contains( $tpl, '{slug}' ) && ( null === $slug || '' === (string) $slug ) ) {
				return null;
			}
		}
		if ( '' === $url ) {
			return null;
		}
		if ( ! preg_match( '#^https?://#i', $url ) ) {
			$url = home_url( '/' . ltrim( $url, '/' ) );
		}
		$url = esc_url_raw( $url );
		if ( ! $url ) {
			return null;
		}

		$mod = $prenormalized && isset( $raw['lastmod'] ) ? $raw['lastmod'] : ( $idx['modifiedField'] ? self::path_get( $raw, $idx['modifiedField'] ) : null );
		if ( is_numeric( $mod ) ) {
			$ts = (int) $mod;
			if ( $ts > 100000000000 ) {
				$ts = (int) floor( $ts / 1000 ); // milliseconds
			}
		} else {
			$ts = $mod ? strtotime( (string) $mod ) : false;
		}
		if ( ! $ts || $ts > time() + DAY_IN_SECONDS ) {
			$ts = time();
		}

		$images = array();
		$rawimg = $prenormalized && isset( $raw['images'] ) ? $raw['images'] : ( $idx['imagesField'] ? self::path_get( $raw, $idx['imagesField'] ) : null );
		if ( is_string( $rawimg ) ) {
			$rawimg = array( $rawimg );
		}
		foreach ( (array) $rawimg as $img ) {
			if ( is_array( $img ) ) {
				$img = $img['url'] ?? $img['src'] ?? $img['large'] ?? '';
			}
			if ( is_string( $img ) && preg_match( '#^https?://#i', $img ) ) {
				$images[] = esc_url_raw( $img );
			}
			if ( count( $images ) >= $idx['maxImages'] ) {
				break;
			}
		}

		$key = $raw['key'] ?? $raw['id'] ?? $raw['mls_num'] ?? $raw['mls'] ?? $raw['listing_id'] ?? null;
		$key = is_scalar( $key ) && '' !== (string) $key ? (string) $key : md5( $url );

		$item = array( 'key' => $key, 'url' => $url, 'lastmod' => $ts, 'images' => $images );
		return apply_filters( 'idxb_seo_idx_item', $item, $raw );
	}

	/** Dry run for the admin "Test connection" button: first page, first 5 normalized items. */
	public static function test_connection( array $idx ): array {
		$res = self::fetch_page( $idx, 1 );
		if ( is_wp_error( $res ) ) {
			return array( 'ok' => false, 'msg' => $res->get_error_message() );
		}
		return array(
			'ok'      => true,
			'msg'     => sprintf( __( '%1$d properties on page 1%2$s.', 'idxboost-seo' ), count( $res['items'] ), $res['has_more'] ? __( ' (more pages available)', 'idxboost-seo' ) : '' ),
			'sample'  => array_slice( $res['items'], 0, 5 ),
		);
	}
}
