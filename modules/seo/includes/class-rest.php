<?php
defined( 'ABSPATH' ) || exit;

class IDXB_SEO_REST {

	const NS = 'idxb-seo/v1';

	public static function init() {
		add_action( 'rest_api_init', array( __CLASS__, 'routes' ) );
	}

	public static function can() {
		return current_user_can( 'manage_options' );
	}

	public static function routes() {
		$r = function ( $path, $methods, $cb ) {
			register_rest_route(
				self::NS,
				$path,
				array(
					'methods'             => $methods,
					'callback'            => $cb,
					'permission_callback' => array( __CLASS__, 'can' ),
				)
			);
		};
		$r( '/settings', 'GET', array( __CLASS__, 'get_settings' ) );
		$r( '/settings', 'POST', array( __CLASS__, 'save_settings' ) );
		$r( '/settings/reset', 'POST', array( __CLASS__, 'reset_settings' ) );
		$r( '/preview/robots', 'POST', array( __CLASS__, 'preview_robots' ) );
		$r( '/preview/sitemap', 'POST', array( __CLASS__, 'preview_sitemap' ) );
		$r( '/status', 'GET', array( __CLASS__, 'status' ) );
		$r( '/status/probe', 'POST', array( __CLASS__, 'probe' ) );
		$r( '/robots/take-control', 'POST', array( __CLASS__, 'robots_take' ) );
		$r( '/robots/sources', 'GET', array( 'IDXB_SEO_Robots', 'sources' ) );
		$r( '/idx/test', 'POST', array( __CLASS__, 'idx_test' ) );
		$r( '/idx/sync', 'POST', array( __CLASS__, 'idx_sync' ) );
		$r( '/idx/status', 'GET', array( __CLASS__, 'idx_status' ) );
		$r( '/tools/flush', 'POST', array( __CLASS__, 'flush' ) );
	}

	/** Draft settings from the request, sanitized, falling back to saved values. */
	private static function draft( WP_REST_Request $req ): array {
		$in = $req->get_param( 'settings' );
		return is_array( $in ) ? IDXB_SEO_Settings::sanitize( $in ) : IDXB_SEO_Settings::get();
	}

	public static function meta(): array {
		$pts = array();
		foreach ( IDXB_SEO_Sitemap_Builder::available_post_types() as $name => $o ) {
			$c     = wp_count_posts( $name );
			$pts[] = array( 'key' => $name, 'label' => $o->labels->name, 'count' => (int) ( $c->publish ?? 0 ) );
		}
		$txs = array();
		foreach ( IDXB_SEO_Sitemap_Builder::available_taxonomies() as $name => $o ) {
			$txs[] = array( 'key' => $name, 'label' => $o->labels->name, 'count' => (int) wp_count_terms( array( 'taxonomy' => $name, 'hide_empty' => false ) ) );
		}
		return array(
			'home'       => home_url( '/' ),
			'postTypes'  => $pts,
			'taxonomies' => $txs,
			'aiBots'     => IDXB_SEO_Robots::ai_bots(),
			'defaults'   => IDXB_SEO_Settings::defaults(),
			'idxKey'     => IDXB_SEO_Provider_IDX_Property::KEY,
		);
	}

	public static function full_status(): array {
		return array(
			'robots'    => IDXB_SEO_Robots::status(),
			'conflicts' => IDXB_SEO_Conflicts::detect(),
			'idx'       => IDXB_SEO_IDX_Sync::status(),
		);
	}

	public static function get_settings() {
		return array( 'settings' => IDXB_SEO_Settings::get(), 'meta' => self::meta(), 'status' => self::full_status() );
	}

	public static function save_settings( WP_REST_Request $req ) {
		$in = $req->get_param( 'settings' );
		if ( ! is_array( $in ) ) {
			return new WP_Error( 'idxb_bad', __( 'Invalid settings', 'idxboost-seo' ), array( 'status' => 400 ) );
		}
		$saved = IDXB_SEO_Settings::save( $in );
		return array( 'settings' => $saved, 'status' => self::full_status() );
	}

	public static function reset_settings() {
		return array( 'settings' => IDXB_SEO_Settings::reset(), 'status' => self::full_status() );
	}

	public static function preview_robots( WP_REST_Request $req ) {
		$s    = self::draft( $req );
		$text = IDXB_SEO_Robots::build( $s );
		$ua   = sanitize_text_field( (string) ( $req->get_param( 'ua' ) ?: 'Googlebot' ) );
		$path = (string) ( $req->get_param( 'path' ) ?: '/' );
		return array(
			'text'     => $text,
			'warnings' => IDXB_SEO_Robots::lint( $s ),
			'test'     => IDXB_SEO_Robots::test( $text, $ua, $path ),
		);
	}

	public static function preview_sitemap( WP_REST_Request $req ) {
		$s = self::draft( $req );
		if ( ! $s['sitemap']['enabled'] ) {
			return array( 'enabled' => false );
		}
		$files = IDXB_SEO_Sitemap_Builder::files( $s );
		$name  = sanitize_file_name( (string) ( $req->get_param( 'file' ) ?: 'sitemap_index.xml' ) );
		$names = array_column( $files, 'name' );
		if ( 'sitemap_index.xml' !== $name && ! in_array( $name, $names, true ) ) {
			$name = 'sitemap_index.xml';
		}
		$entries = array();
		if ( 'sitemap_index.xml' === $name ) {
			$xml = IDXB_SEO_Sitemap_Builder::render_index( $s, $files );
		} else {
			list( $key, $page ) = IDXB_SEO_Sitemap_Builder::parse_file_name( $name );
			$all                = (array) IDXB_SEO_Sitemap_Builder::entries( $s, $key, $page );
			$xml                = IDXB_SEO_Sitemap_Builder::render_urlset( $s, $all );
			$entries            = array_map(
				fn( $e ) => array( 'loc' => $e['loc'], 'lastmod' => (int) $e['lastmod'], 'images' => count( (array) $e['images'] ) ),
				array_slice( $all, 0, 500 )
			);
			$entries_total = count( $all );
		}
		return array(
			'enabled'      => true,
			'file'         => $name,
			'url'          => home_url( '/' . $name ),
			'files'        => $files,
			'summary'      => IDXB_SEO_Sitemap_Builder::summary( $s, $files ),
			'xml'          => strlen( $xml ) > 400000 ? substr( $xml, 0, 400000 ) . "\n<!-- … truncated in the preview -->" : $xml,
			'entries'      => $entries,
			'entriesTotal' => $entries_total ?? 0,
		);
	}

	public static function status() {
		return self::full_status();
	}

	public static function probe() {
		$robots = IDXB_SEO_Robots::apply_mode();
		return array(
			'robots'  => $robots,
			'sitemap' => IDXB_SEO_Settings::get()['sitemap']['enabled'] ? IDXB_SEO_Conflicts::probe_sitemap() : null,
			'status'  => self::full_status(),
		);
	}

	public static function robots_take() {
		$res = IDXB_SEO_Robots::take_control();
		return $res + array( 'settings' => IDXB_SEO_Settings::get(), 'status' => self::full_status() );
	}

	public static function idx_test( WP_REST_Request $req ) {
		return IDXB_SEO_IDX_Sync::test_connection( self::draft( $req )['idx'] );
	}

	public static function idx_sync() {
		if ( ! IDXB_SEO_Settings::get()['idx']['enabled'] ) {
			return new WP_Error( 'idxb_off', __( 'Turn on and save the IDX property sitemap first.', 'idxboost-seo' ), array( 'status' => 400 ) );
		}
		$st = IDXB_SEO_IDX_Sync::start();
		if ( 'running' === $st['status'] ) {
			spawn_cron();
		}
		return $st;
	}

	public static function idx_status() {
		return IDXB_SEO_IDX_Sync::status();
	}

	public static function flush() {
		flush_rewrite_rules( false );
		IDXB_SEO_Cache::bump();
		return array( 'ok' => true );
	}
}
