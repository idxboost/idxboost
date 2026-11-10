<?php
defined( 'ABSPATH' ) || exit;

/**
 * Serves sitemap_index.xml, {key}-sitemap{n}.xml and main-sitemap.xsl.
 * Matching is done on the raw request path, so it works even if another plugin owns the rewrite rule.
 */
class IDXB_SEO_Sitemap_Router {

	public static function init() {
		add_action( 'init', array( __CLASS__, 'add_rules' ), 1 );
		add_action( 'init', array( __CLASS__, 'maybe_flush' ), 99 );
		add_filter( 'query_vars', array( __CLASS__, 'query_vars' ) );
		add_action( 'parse_request', array( __CLASS__, 'handle' ), 0 );
		add_filter( 'redirect_canonical', array( __CLASS__, 'no_trailing_slash' ), 10, 2 );
	}

	public static function add_rules() {
		add_rewrite_rule( '^sitemap_index\.xml$', 'index.php?idxb_sitemap=sitemap_index.xml', 'top' );
		add_rewrite_rule( '^([a-z0-9_\-]+?-sitemap[0-9]*\.xml)$', 'index.php?idxb_sitemap=$matches[1]', 'top' );
		add_rewrite_rule( '^main-sitemap\.xsl$', 'index.php?idxb_sitemap=main-sitemap.xsl', 'top' );
	}

	public static function maybe_flush() {
		if ( get_option( 'idxb_seo_rewrite_ver' ) !== IDXB_SEO_VERSION ) {
			flush_rewrite_rules( false );
			update_option( 'idxb_seo_rewrite_ver', IDXB_SEO_VERSION );
			IDXB_SEO_Robots::apply_mode(); // rewrite the managed robots.txt with the new version's output
		}
	}

	public static function query_vars( $vars ) {
		$vars[] = 'idxb_sitemap';
		return $vars;
	}

	public static function no_trailing_slash( $redirect, $requested ) {
		$path = (string) wp_parse_url( $requested, PHP_URL_PATH );
		return preg_match( '#(sitemap[0-9]*\.xml|sitemap_index\.xml|main-sitemap\.xsl)$#', $path ) ? false : $redirect;
	}

	private static function requested_file( $wp ): string {
		if ( ! empty( $wp->query_vars['idxb_sitemap'] ) ) {
			return (string) $wp->query_vars['idxb_sitemap'];
		}
		$path = trim( (string) $wp->request, '/' );
		if ( '' === $path ) {
			$path = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
			$home = trim( (string) wp_parse_url( home_url(), PHP_URL_PATH ), '/' );
			if ( $home && str_starts_with( $path, $home . '/' ) ) {
				$path = substr( $path, strlen( $home ) + 1 );
			}
		}
		return $path;
	}

	public static function handle( $wp ) {
		$settings = IDXB_SEO_Settings::get();
		if ( ! $settings['sitemap']['enabled'] ) {
			return;
		}
		$file = self::requested_file( $wp );
		if ( '' === $file || str_contains( $file, '/' ) ) {
			return;
		}

		// Legacy / core / generic sitemap URLs → our index.
		if ( in_array( $file, array( 'sitemap.xml', 'wp-sitemap.xml', 'sitemap-index.xml' ), true ) && $settings['sitemap']['takeOver'] ) {
			wp_safe_redirect( home_url( '/sitemap_index.xml' ), 301, 'IDXBoost SEO' );
			exit;
		}

		if ( 'main-sitemap.xsl' === $file ) {
			self::send_xsl();
		}

		if ( 'sitemap_index.xml' !== $file && ! preg_match( '/^[a-z0-9_\-]+?-sitemap[0-9]*\.xml$/', $file ) ) {
			return;
		}
		$xml = IDXB_SEO_Sitemap_Builder::xml_for( $file );
		if ( null === $xml ) {
			status_header( 404 );
			nocache_headers();
			header( 'Content-Type: text/plain; charset=UTF-8' );
			echo 'Sitemap not found';
			exit;
		}
		self::send( $xml, 'application/xml' );
	}

	private static function send( string $body, string $type ) {
		status_header( 200 );
		header( 'Content-Type: ' . $type . '; charset=UTF-8' );
		header( 'X-Robots-Tag: noindex, follow', true );
		header( 'Cache-Control: max-age=' . HOUR_IN_SECONDS . ', public' );
		header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
		echo $body; // phpcs:ignore WordPress.Security.EscapeOutput -- XML built with escaped values.
		exit;
	}

	private static function send_xsl() {
		$xsl = (string) file_get_contents( IDXB_SEO_DIR . 'assets/main-sitemap.xsl' ); // phpcs:ignore
		self::send( $xsl, 'text/xsl' );
	}
}
