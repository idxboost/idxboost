<?php
defined( 'ABSPATH' ) || exit;

class IDXB_SEO_Sitemap_Builder {

	private static $ctx = array();

	/* ---------- discovery ---------- */

	/** Public post types that can go in a sitemap. */
	public static function available_post_types(): array {
		$out = array();
		foreach ( get_post_types( array( 'public' => true ), 'objects' ) as $pt ) {
			if ( 'attachment' === $pt->name ) {
				continue;
			}
			$out[ $pt->name ] = $pt;
		}
		// post and page first, then the rest alphabetically (IDX CPTs, landings…).
		uksort(
			$out,
			function ( $a, $b ) {
				$rank = array( 'post' => 0, 'page' => 1 );
				return ( $rank[ $a ] ?? 2 ) <=> ( $rank[ $b ] ?? 2 ) ?: strcmp( $a, $b );
			}
		);
		return $out;
	}

	public static function available_taxonomies(): array {
		$out = array();
		foreach ( get_taxonomies( array( 'public' => true ), 'objects' ) as $tx ) {
			if ( in_array( $tx->name, array( 'nav_menu', 'link_category', 'wp_theme', 'wp_template_part_area', 'wp_pattern_category' ), true ) ) {
				continue;
			}
			if ( empty( $tx->publicly_queryable ) && 'post_format' !== $tx->name ) {
				continue;
			}
			$out[ $tx->name ] = $tx;
		}
		return $out;
	}

	/** @return IDXB_SEO_Provider[] keyed by file prefix */
	public static function providers( array $settings ): array {
		$list = array();
		foreach ( array_keys( self::available_post_types() ) as $pt ) {
			if ( IDXB_SEO_Settings::post_type_enabled( $settings, $pt ) ) {
				$list[ $pt ] = new IDXB_SEO_Provider_Post_Type( $pt );
			}
		}
		foreach ( array_keys( self::available_taxonomies() ) as $tx ) {
			if ( IDXB_SEO_Settings::taxonomy_enabled( $settings, $tx ) && ! isset( $list[ $tx ] ) ) {
				$list[ $tx ] = new IDXB_SEO_Provider_Taxonomy( $tx );
			}
		}
		if ( $settings['sitemap']['authors']['enabled'] && ! isset( $list['author'] ) ) {
			$list['author'] = new IDXB_SEO_Provider_Author();
		}
		if ( $settings['idx']['enabled'] ) {
			$list[ IDXB_SEO_Provider_IDX_Property::KEY ] = new IDXB_SEO_Provider_IDX_Property();
		}
		return apply_filters( 'idxb_seo_sitemap_providers', $list, $settings );
	}

	/* ---------- shared context (exclusions) ---------- */

	public static function context( array $settings ): array {
		$hash = md5( wp_json_encode( $settings['sitemap'] ) . '|' . (int) $settings['idx']['enabled'] );
		if ( isset( self::$ctx[ $hash ] ) ) {
			return self::$ctx[ $hash ];
		}
		global $wpdb;
		$sm      = $settings['sitemap'];
		$reasons = array( 'manual' => 0, 'noindex' => 0, 'canonical' => 0, 'path' => 0 );
		$ex      = array();

		foreach ( IDXB_SEO_Settings::parse_ids( $sm['excludePostIds'] ) as $id ) {
			$ex[ $id ] = 'manual';
		}

		// noindex flags from this plugin, Yoast and Rank Math.
		$noindex = $wpdb->get_col(
			"SELECT DISTINCT post_id FROM {$wpdb->postmeta}
			 WHERE ( meta_key = '_idxb_seo_exclude' AND meta_value = '1' )
			    OR ( meta_key = '_yoast_wpseo_meta-robots-noindex' AND meta_value = '1' )
			    OR ( meta_key = 'rank_math_robots' AND meta_value LIKE '%noindex%' )"
		);
		foreach ( $noindex as $id ) {
			$ex[ (int) $id ] = $ex[ (int) $id ] ?? 'noindex';
		}

		// Canonical pointing somewhere else.
		$canon = $wpdb->get_results(
			"SELECT post_id, meta_value FROM {$wpdb->postmeta}
			 WHERE meta_key IN ( '_yoast_wpseo_canonical', 'rank_math_canonical_url' ) AND meta_value <> ''"
		);
		foreach ( $canon as $c ) {
			$id = (int) $c->post_id;
			if ( isset( $ex[ $id ] ) ) {
				continue;
			}
			$perma = get_permalink( $id );
			if ( $perma && self::norm_url( $perma ) !== self::norm_url( $c->meta_value ) ) {
				$ex[ $id ] = 'canonical';
			}
		}

		// Paths → post IDs (so counts stay right); patterns ending in * are matched against each URL later.
		$paths = self::parse_paths( $sm['excludePaths'] );
		foreach ( $paths as $p ) {
			if ( str_ends_with( $p, '*' ) ) {
				continue;
			}
			$id = url_to_postid( home_url( $p . '/' ) );
			if ( ! $id ) {
				$page = get_page_by_path( ltrim( $p, '/' ), OBJECT, array_keys( self::available_post_types() ) );
				$id   = $page ? $page->ID : 0;
			}
			if ( $id && ! isset( $ex[ $id ] ) ) {
				$ex[ $id ] = 'path';
			}
		}

		// Count reasons only for published content (drafts are never listed anyway).
		if ( $ex ) {
			$ids_in = implode( ',', array_map( 'intval', array_keys( $ex ) ) );
			$pub    = $wpdb->get_col( "SELECT ID FROM {$wpdb->posts} WHERE post_status = 'publish' AND ID IN ($ids_in)" ); // phpcs:ignore
			foreach ( $pub as $id ) {
				$reasons[ $ex[ (int) $id ] ]++;
			}
		}

		// Homepage data.
		$front_id = 'page' === get_option( 'show_on_front' ) ? (int) get_option( 'page_on_front' ) : 0;
		if ( $front_id ) {
			$home_ts = idxb_seo_gmt_ts( get_post_field( 'post_modified_gmt', $front_id ) );
		} else {
			$latest  = $wpdb->get_var( "SELECT MAX(post_modified_gmt) FROM {$wpdb->posts} WHERE post_status = 'publish' AND post_type = 'post'" );
			$home_ts = idxb_seo_gmt_ts( $latest );
		}

		$ctx = array(
			'hash'           => $hash,
			'per'            => (int) $sm['entriesPerPage'],
			'excluded_ids'   => $ex,
			'excluded_terms' => array_flip( IDXB_SEO_Settings::parse_ids( $sm['excludeTermIds'] ) ),
			'excluded_paths' => $paths,
			'reasons'        => $reasons,
			'front_page_id'  => $front_id,
			'home_lastmod'   => $home_ts,
		);
		self::$ctx[ $hash ] = $ctx;
		return $ctx;
	}

	public static function parse_paths( string $text ): array {
		$out = array();
		foreach ( preg_split( '/[\r\n]+/', $text ) as $line ) {
			$line = trim( $line );
			if ( '' === $line ) {
				continue;
			}
			if ( preg_match( '#^https?://#i', $line ) ) {
				$line = (string) wp_parse_url( $line, PHP_URL_PATH );
			}
			$out[] = self::norm_path( $line );
		}
		return array_values( array_unique( $out ) );
	}

	public static function norm_path( string $p ): string {
		$p = '/' . trim( strtolower( $p ), '/' );
		return '/' === $p ? '/' : $p;
	}

	private static function norm_url( string $u ): string {
		$parts = wp_parse_url( trim( $u ) );
		return strtolower( ( $parts['host'] ?? '' ) ) . self::norm_path( $parts['path'] ?? '/' );
	}

	/** Path-based exclusion for any URL (terms, authors, IDX listings…). */
	public static function is_path_excluded( string $loc, array $ctx ): bool {
		if ( ! $ctx['excluded_paths'] ) {
			return false;
		}
		$path = self::norm_path( (string) wp_parse_url( $loc, PHP_URL_PATH ) );
		foreach ( $ctx['excluded_paths'] as $p ) {
			if ( str_ends_with( $p, '*' ) ) {
				if ( str_starts_with( $path, rtrim( substr( $p, 0, -1 ), '/' ) ) ) {
					return true;
				}
			} elseif ( $path === $p ) {
				return true;
			}
		}
		return false;
	}

	/* ---------- model ---------- */

	public static function file_name( string $key, int $page ): string {
		return $key . '-sitemap' . ( $page > 1 ? $page : '' ) . '.xml';
	}

	/** List of files: [ name, key, page, count, lastmod ]. */
	public static function files( array $settings ): array {
		$ctx   = self::context( $settings );
		$files = array();
		foreach ( self::providers( $settings ) as $key => $prov ) {
			foreach ( $prov->pages( $settings, $ctx ) as $pg ) {
				$files[] = array(
					'name'    => self::file_name( $key, $pg['page'] ),
					'key'     => $key,
					'label'   => $prov->label(),
					'page'    => $pg['page'],
					'count'   => $pg['count'],
					'lastmod' => $pg['lastmod'],
				);
			}
		}
		return $files;
	}

	/** Entries for "{key}-sitemap{n}.xml" or null if it doesn't exist. */
	public static function entries( array $settings, string $key, int $page ): ?array {
		$providers = self::providers( $settings );
		if ( ! isset( $providers[ $key ] ) || $page < 1 ) {
			return null;
		}
		$ctx   = self::context( $settings );
		$pages = $providers[ $key ]->pages( $settings, $ctx );
		if ( $page > count( $pages ) ) {
			return null;
		}
		$entries = $providers[ $key ]->entries( $settings, $ctx, $page );
		return array_values( array_filter( $entries, fn( $e ) => ! self::is_path_excluded( $e['loc'], $ctx ) ) );
	}

	/** Split "flex-idx-building-sitemap2.xml" into [ key, page ]. */
	public static function parse_file_name( string $name ): ?array {
		if ( ! preg_match( '/^([a-z0-9_\-]+?)-sitemap([0-9]*)\.xml$/', $name, $m ) ) {
			return null;
		}
		return array( $m[1], '' === $m[2] ? 1 : (int) $m[2] );
	}

	/* ---------- rendering ---------- */

	private static function iso( int $ts ): string {
		return gmdate( 'c', $ts );
	}

	private static function esc( string $s ): string {
		return htmlspecialchars( $s, ENT_QUOTES | ENT_XML1, 'UTF-8' );
	}

	private static function head( array $settings ): array {
		$out = array( '<?xml version="1.0" encoding="UTF-8"?>' );
		if ( $settings['sitemap']['xsl'] ) {
			$out[] = '<?xml-stylesheet type="text/xsl" href="' . self::esc( home_url( '/main-sitemap.xsl' ) ) . '"?>';
		}
		return $out;
	}

	public static function render_index( array $settings, ?array $files = null ): string {
		$files = $files ?? self::files( $settings );
		$out   = self::head( $settings );
		$out[] = '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		foreach ( $files as $f ) {
			$out[] = "\t<sitemap>";
			$out[] = "\t\t<loc>" . self::esc( home_url( '/' . $f['name'] ) ) . '</loc>';
			$out[] = "\t\t<lastmod>" . self::iso( $f['lastmod'] ) . '</lastmod>';
			$out[] = "\t</sitemap>";
		}
		$out[] = '</sitemapindex>';
		$out[] = '<!-- XML Sitemap generated by IDXBoost SEO ' . IDXB_SEO_VERSION . ' -->';
		return implode( "\n", $out ) . "\n";
	}

	public static function render_urlset( array $settings, array $entries ): string {
		$has_img = (bool) array_filter( $entries, fn( $e ) => ! empty( $e['images'] ) );
		$out     = self::head( $settings );
		$out[]   = '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"'
			. ( $has_img ? ' xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"' : '' )
			. ' xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd'
			. ( $has_img ? ' http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd' : '' )
			. '" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		foreach ( $entries as $e ) {
			$out[] = "\t<url>";
			$out[] = "\t\t<loc>" . self::esc( $e['loc'] ) . '</loc>';
			$out[] = "\t\t<lastmod>" . self::iso( (int) $e['lastmod'] ) . '</lastmod>';
			foreach ( (array) $e['images'] as $img ) {
				$out[] = "\t\t<image:image>\n\t\t\t<image:loc>" . self::esc( $img ) . "</image:loc>\n\t\t</image:image>";
			}
			$out[] = "\t</url>";
		}
		$out[] = '</urlset>';
		$out[] = '<!-- XML Sitemap generated by IDXBoost SEO ' . IDXB_SEO_VERSION . ' -->';
		return implode( "\n", $out ) . "\n";
	}

	/**
	 * Public entry point used by the router: rendered XML for a file name, cached; null = 404.
	 */
	public static function xml_for( string $name ): ?string {
		$settings = IDXB_SEO_Settings::get();
		if ( 'sitemap_index.xml' === $name ) {
			return IDXB_SEO_Cache::remember( 'index', fn() => self::render_index( $settings ) );
		}
		$parsed = self::parse_file_name( $name );
		if ( ! $parsed ) {
			return null;
		}
		$cached = IDXB_SEO_Cache::get( 'file:' . $name );
		if ( false !== $cached ) {
			return '' === $cached ? null : $cached;
		}
		$entries = self::entries( $settings, $parsed[0], $parsed[1] );
		if ( null === $entries ) {
			return null; // not cached: random names from bots must not fill the options table
		}
		$xml = self::render_urlset( $settings, $entries );
		IDXB_SEO_Cache::set( 'file:' . $name, $xml );
		return $xml;
	}

	/** Summary for the admin preview. */
	public static function summary( array $settings, array $files ): array {
		$ctx = self::context( $settings );
		return array(
			'files'    => count( $files ),
			'urls'     => array_sum( array_column( $files, 'count' ) ),
			'perPage'  => $ctx['per'],
			'excluded' => array_sum( $ctx['reasons'] ),
			'reasons'  => $ctx['reasons'],
		);
	}
}
