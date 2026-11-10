<?php
defined( 'ABSPATH' ) || exit;

/**
 * Settings contract (schemaVersion 1) — same shape as the MVP demo JSON, extended for production.
 */
class IDXB_SEO_Settings {

	const OPTION         = 'idxb_seo_settings';
	const SCHEMA_VERSION = 1;

	private static $cache = null;

	public static function defaults(): array {
		return array(
			'schemaVersion' => self::SCHEMA_VERSION,
			'sitemap'       => array(
				'enabled'          => true,
				'postTypes'        => array(),   // name => bool (missing = default)
				'taxonomies'       => array(),   // name => bool (missing = default)
				'authors'          => array( 'enabled' => true, 'excludeNoPosts' => true ),
				'entriesPerPage'   => 1000,
				'includeImages'    => true,
				'excludeEmptyTerms'=> true,
				'excludePostIds'   => '',
				'excludeTermIds'   => '',
				'excludePaths'     => "/property/\n/my-saved-properties/\n/my-saved-searches/\n/my-saved-buildings/\n/my-profile/",
				'xsl'              => true,
				'takeOver'         => true,     // disable Yoast / Rank Math / core sitemaps while ours are on
			),
			'idx'           => array(
				'enabled'       => false,
				'endpoint'      => '',          // supports {page} and {per_page}
				'authHeader'    => '',          // e.g. "Authorization: Bearer xxx"
				'perPage'       => 200,
				'maxPages'      => 500,
				'itemsPath'     => 'items',
				'urlField'      => '',          // absolute/relative URL field; wins over slug template
				'slugField'     => 'slug',
				'urlTemplate'   => '/property/{slug}',
				'modifiedField' => 'modified',
				'imagesField'   => 'images',
				'maxImages'     => 3,
				'schedule'      => 'daily',     // hourly | twicedaily | daily
			),
			'robots'        => array(
				'mode'           => 'auto',      // auto | virtual | file
				'customContent'  => "User-agent: *\nDisallow: /wp-admin/\nAllow: /wp-admin/admin-ajax.php\nDisallow: /wp-login.php\n",
				'denySearch'     => true,
				'denyIdxParams'  => false,
				'idxParams'      => "keyword\nsortby",
				'denyWpJson'     => false,
				'denyAdsBot'     => false,
				'ai'             => IDXB_SEO_Robots::default_ai_states(),
				'includeSitemap' => true,
				'respectDiscourage' => false,  // block all when Settings > Reading discourages search engines
			),
		);
	}

	public static function get(): array {
		if ( null === self::$cache ) {
			$raw         = get_option( self::OPTION, array() );
			self::$cache = self::merge( self::defaults(), is_array( $raw ) ? $raw : array() );
		}
		return self::$cache;
	}

	public static function save( array $input ): array {
		$clean = self::sanitize( $input );
		update_option( self::OPTION, $clean, true );
		self::$cache = null;
		IDXB_SEO_Cache::bump();
		IDXB_SEO_Robots::apply_mode();
		IDXB_SEO_IDX_Sync::reschedule();
		return self::get();
	}

	public static function reset(): array {
		delete_option( self::OPTION );
		self::$cache = null;
		IDXB_SEO_Cache::bump();
		IDXB_SEO_Robots::apply_mode();
		IDXB_SEO_IDX_Sync::reschedule();
		return self::get();
	}

	/** Recursive merge: keeps default keys/types, takes saved values. Free-form maps are taken as-is. */
	public static function merge( $base, $over ) {
		if ( ! is_array( $base ) ) {
			return ( null === $over || is_array( $over ) ) ? $base : $over;
		}
		if ( array() === $base ) { // free-form map (postTypes, taxonomies): take saved map as-is
			return is_array( $over ) ? $over : $base;
		}
		$out = array();
		foreach ( $base as $k => $v ) {
			$out[ $k ] = ( is_array( $over ) && array_key_exists( $k, $over ) ) ? self::merge( $v, $over[ $k ] ) : $v;
		}
		return $out;
	}

	public static function sanitize( array $in ): array {
		$d   = self::defaults();
		$sm  = is_array( $in['sitemap'] ?? null ) ? $in['sitemap'] : array();
		$idx = is_array( $in['idx'] ?? null ) ? $in['idx'] : array();
		$rb  = is_array( $in['robots'] ?? null ) ? $in['robots'] : array();

		$out                  = $d;
		$out['schemaVersion'] = self::SCHEMA_VERSION;

		// Sitemap.
		$s                       = &$out['sitemap'];
		$s['enabled']            = self::bool( $sm, 'enabled', $s['enabled'] );
		$s['postTypes']          = self::bool_map( $sm['postTypes'] ?? array() );
		$s['taxonomies']         = self::bool_map( $sm['taxonomies'] ?? array() );
		$au                      = is_array( $sm['authors'] ?? null ) ? $sm['authors'] : array();
		$s['authors']['enabled'] = self::bool( $au, 'enabled', $s['authors']['enabled'] );
		$s['authors']['excludeNoPosts'] = self::bool( $au, 'excludeNoPosts', $s['authors']['excludeNoPosts'] );
		$s['entriesPerPage']     = self::int( $sm, 'entriesPerPage', $s['entriesPerPage'], 1, 50000 );
		$s['includeImages']      = self::bool( $sm, 'includeImages', $s['includeImages'] );
		$s['excludeEmptyTerms']  = self::bool( $sm, 'excludeEmptyTerms', $s['excludeEmptyTerms'] );
		$s['excludePostIds']     = self::id_list( $sm['excludePostIds'] ?? '' );
		$s['excludeTermIds']     = self::id_list( $sm['excludeTermIds'] ?? '' );
		$s['excludePaths']       = isset( $sm['excludePaths'] ) ? self::textarea( $sm['excludePaths'] ) : $s['excludePaths'];
		$s['xsl']                = self::bool( $sm, 'xsl', $s['xsl'] );
		$s['takeOver']           = self::bool( $sm, 'takeOver', $s['takeOver'] );
		unset( $s );

		// IDX listings.
		$i                  = &$out['idx'];
		$i['enabled']       = self::bool( $idx, 'enabled', $i['enabled'] );
		$i['endpoint']      = isset( $idx['endpoint'] ) ? self::endpoint( $idx['endpoint'] ) : '';
		$i['authHeader']    = isset( $idx['authHeader'] ) ? trim( sanitize_text_field( (string) $idx['authHeader'] ) ) : '';
		$i['perPage']       = self::int( $idx, 'perPage', $i['perPage'], 1, 1000 );
		$i['maxPages']      = self::int( $idx, 'maxPages', $i['maxPages'], 1, 10000 );
		foreach ( array( 'itemsPath', 'urlField', 'slugField', 'modifiedField', 'imagesField' ) as $k ) {
			if ( isset( $idx[ $k ] ) ) {
				$i[ $k ] = preg_replace( '/[^A-Za-z0-9_.\-]/', '', (string) $idx[ $k ] );
			}
		}
		if ( isset( $idx['urlTemplate'] ) ) {
			$tpl              = trim( sanitize_text_field( (string) $idx['urlTemplate'] ) );
			$i['urlTemplate'] = '' === $tpl ? $d['idx']['urlTemplate'] : $tpl;
		}
		$i['maxImages'] = self::int( $idx, 'maxImages', $i['maxImages'], 0, 20 );
		$i['schedule']  = in_array( $idx['schedule'] ?? '', array( 'hourly', 'twicedaily', 'daily' ), true ) ? $idx['schedule'] : $i['schedule'];
		unset( $i );

		// Robots.
		$r                   = &$out['robots'];
		$r['mode']           = in_array( $rb['mode'] ?? '', array( 'auto', 'virtual', 'file' ), true ) ? $rb['mode'] : $r['mode'];
		$r['customContent']  = isset( $rb['customContent'] ) ? self::robots_text( $rb['customContent'] ) : $r['customContent'];
		$r['denySearch']     = self::bool( $rb, 'denySearch', $r['denySearch'] );
		$r['denyIdxParams']  = self::bool( $rb, 'denyIdxParams', $r['denyIdxParams'] );
		$r['idxParams']      = isset( $rb['idxParams'] ) ? self::param_list( $rb['idxParams'] ) : $r['idxParams'];
		$r['denyWpJson']     = self::bool( $rb, 'denyWpJson', $r['denyWpJson'] );
		$r['denyAdsBot']     = self::bool( $rb, 'denyAdsBot', $r['denyAdsBot'] );
		$r['includeSitemap'] = self::bool( $rb, 'includeSitemap', $r['includeSitemap'] );
		$r['respectDiscourage'] = self::bool( $rb, 'respectDiscourage', $r['respectDiscourage'] );
		$ai                  = is_array( $rb['ai'] ?? null ) ? $rb['ai'] : array();
		foreach ( $r['ai'] as $ua => $state ) {
			if ( isset( $ai[ $ua ] ) && in_array( $ai[ $ua ], array( 'default', 'allow', 'block' ), true ) ) {
				$r['ai'][ $ua ] = $ai[ $ua ];
			}
		}
		unset( $r );

		return $out;
	}

	/* ---------- helpers ---------- */

	public static function post_type_enabled( array $settings, string $pt ): bool {
		$map = $settings['sitemap']['postTypes'];
		return array_key_exists( $pt, $map ) ? (bool) $map[ $pt ] : 'attachment' !== $pt;
	}

	public static function taxonomy_enabled( array $settings, string $tax ): bool {
		$map = $settings['sitemap']['taxonomies'];
		return array_key_exists( $tax, $map ) ? (bool) $map[ $tax ] : 'post_format' !== $tax;
	}

	public static function parse_ids( string $s ): array {
		$ids = array_filter( array_map( 'absint', preg_split( '/[\s,]+/', $s ) ) );
		return array_values( array_unique( $ids ) );
	}

	private static function bool( array $a, string $k, bool $def ): bool {
		if ( ! array_key_exists( $k, $a ) ) {
			return $def;
		}
		return filter_var( $a[ $k ], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE ) ?? $def;
	}

	private static function int( array $a, string $k, int $def, int $min, int $max ): int {
		if ( ! isset( $a[ $k ] ) || ! is_numeric( $a[ $k ] ) ) {
			return $def;
		}
		return max( $min, min( $max, (int) $a[ $k ] ) );
	}

	private static function bool_map( $m ): array {
		$out = array();
		if ( is_array( $m ) ) {
			foreach ( $m as $k => $v ) {
				$key = sanitize_key( (string) $k );
				if ( '' !== $key ) {
					$out[ $key ] = (bool) filter_var( $v, FILTER_VALIDATE_BOOLEAN );
				}
			}
		}
		return $out;
	}

	private static function id_list( $s ): string {
		return implode( ', ', self::parse_ids( (string) $s ) );
	}

	private static function textarea( $s ): string {
		$s = str_replace( array( "\r\n", "\r" ), "\n", wp_strip_all_tags( (string) $s, false ) );
		return trim( $s );
	}

	private static function robots_text( $s ): string {
		$s = str_replace( array( "\r\n", "\r" ), "\n", wp_strip_all_tags( (string) $s, false ) );
		$s = preg_replace( '/[^\P{C}\n\t]/u', '', $s ); // drop control chars except newline/tab
		return rtrim( (string) $s ) . "\n";
	}

	private static function param_list( $s ): string {
		$lines = preg_split( '/[\s,]+/', (string) $s );
		$lines = array_filter( array_map( fn( $p ) => preg_replace( '/[^A-Za-z0-9_\-\[\]]/', '', $p ), $lines ) );
		return implode( "\n", array_unique( $lines ) );
	}

	private static function endpoint( $url ): string {
		// Keep {page}/{per_page} placeholders through esc_url_raw.
		$url = str_replace( array( '{page}', '{per_page}' ), array( '__IDXB_PAGE__', '__IDXB_PER__' ), trim( (string) $url ) );
		$url = esc_url_raw( $url, array( 'http', 'https' ) );
		return str_replace( array( '__IDXB_PAGE__', '__IDXB_PER__' ), array( '{page}', '{per_page}' ), $url );
	}
}
