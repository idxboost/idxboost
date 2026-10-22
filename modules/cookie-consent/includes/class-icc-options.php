<?php
/**
 * Options: defaults, retrieval and sanitization.
 *
 * @package IDX_Cookie_Consent
 */

defined( 'ABSPATH' ) || exit;

/**
 * Single-option storage (`icc_options`).
 */
class ICC_Options {

	const KEY  = 'icc_options';
	const CATS = array( 'analytics', 'marketing', 'preferences' );

	/**
	 * Request-level cache.
	 *
	 * @var array|null
	 */
	private static $cache = null;

	/**
	 * EU/EEA + UK + Switzerland (default list also adds US-CA = California).
	 */
	const EU_COUNTRIES = 'AT,BE,BG,HR,CY,CZ,DK,EE,FI,FR,DE,GR,HU,IE,IT,LV,LT,LU,MT,NL,PL,PT,RO,SK,SI,ES,SE,IS,LI,NO,GB,CH';

	/**
	 * Default values.
	 *
	 * @return array
	 */
	public static function defaults() {
		return array(
			'enabled'          => apply_filters( 'icc_default_enabled', 1 ) ? 1 : 0,
			'layout'           => 'bar',
			'message'          => 'We use cookies to improve your experience, analyze site traffic and personalize content. You can accept all cookies, reject non-essential ones or choose your preferences.',
			'policy_text'      => 'Privacy Policy',
			'policy_url'       => '',
			'btn_accept'       => 'Accept all',
			'btn_reject'       => 'Reject all',
			'btn_settings'     => 'Preferences',
			'btn_save'         => 'Save preferences',
			'reject_in_banner' => 0, // "Reject all" lives in Preferences; optional in the banner.
			'prefs_title'      => 'Cookie preferences',
			'prefs_intro'      => 'Choose which cookies you allow. Strictly necessary cookies are always active because the site cannot work without them.',
			'necessary_label'  => 'Strictly necessary',
			'necessary_desc'   => 'Required for the website to function (security, session, saving your cookie choice).',
			'always_active'    => 'Always active',
			'color_bg'         => '#1f2937',
			'color_text'       => '#ffffff',
			'color_btn'        => '#2563eb',
			'color_btn_text'   => '#ffffff',
			'color_link'       => '#93c5fd',
			'radius'           => 6,
			'fab'              => 1,
			'fab_position'     => 'left',
			'fab_label'        => 'Cookie settings',
			'necessary_head'   => '',
			'necessary_body'   => '',
			'cats'             => array(
				'analytics'   => array(
					'enabled' => 1,
					'label'   => 'Analytics',
					'desc'    => 'Help us understand how visitors use the site so we can improve it (e.g. Google Analytics).',
					'head'    => '',
					'body'    => '',
					'delete'  => "_ga\n_gid\n_gat\n_clck\n_clsk",
					'zaraz'   => '',
				),
				'marketing'   => array(
					'enabled' => 1,
					'label'   => 'Marketing',
					'desc'    => 'Used to show relevant ads and measure campaigns (e.g. Google Ads, Meta Pixel).',
					'head'    => '',
					'body'    => '',
					'delete'  => "_fbp\n_fbc\n_gcl\n_ttp\n_uet",
					'zaraz'   => '',
				),
				'preferences' => array(
					'enabled' => 0,
					'label'   => 'Preferences',
					'desc'    => 'Remember your choices such as language or region.',
					'head'    => '',
					'body'    => '',
					'delete'  => '',
					'zaraz'   => '',
				),
			),
			'gcm'              => 1,
			'gcm_redaction'    => 1,
			'gcm_passthrough'  => 0,
			'zaraz'            => 0,
			'handles'          => '',
			'geo'              => 0,
			'geo_countries'    => self::EU_COUNTRIES . ',US-CA',
			'geo_tz'           => 1,
			'geo_europe'       => 1,
			'geo_cookie'       => 'icc_country',
			'geo_unknown'      => 'tz',
			'cookie_name'      => 'icc_consent',
			'cookie_days'      => 180,
			'cookie_domain'    => '',
			'revision'         => 1,
			'reload_on_revoke' => 1,
			'gpc'              => 1,
			'idxb_compat'      => 1,
			'idxb_crm_cat'     => 'marketing',
			'idxb_gtm_cat'     => 'marketing',
			'gpc_text'         => 'We detected a Global Privacy Control signal from your browser and have turned off the sale/sharing of your personal information (marketing cookies).',
			'dns_text'         => 'Do Not Sell or Share My Personal Information',
		);
	}

	/**
	 * Saved options merged over defaults.
	 *
	 * @return array
	 */
	public static function get() {
		if ( null === self::$cache ) {
			$d     = self::defaults();
			$saved = get_option( self::KEY, array() );
			$saved = is_array( $saved ) ? $saved : array();
			$o     = array_merge( $d, $saved );
			foreach ( self::CATS as $c ) {
				$o['cats'][ $c ] = array_merge( $d['cats'][ $c ], isset( $saved['cats'][ $c ] ) && is_array( $saved['cats'][ $c ] ) ? $saved['cats'][ $c ] : array() );
			}
			self::$cache = apply_filters( 'icc_options', $o );
		}
		return self::$cache;
	}

	/**
	 * Clear the request cache (after saving).
	 */
	public static function flush() {
		self::$cache = null;
	}

	/**
	 * Parse "handle:category" lines.
	 *
	 * @param string $raw Raw textarea value.
	 * @return array handle => category
	 */
	public static function parse_handles( $raw ) {
		$map = array();
		foreach ( preg_split( '/\R/', (string) $raw ) as $line ) {
			$p = array_map( 'trim', explode( ':', $line, 2 ) );
			if ( 2 === count( $p ) && '' !== $p[0] && in_array( $p[1], self::CATS, true ) ) {
				$map[ $p[0] ] = $p[1];
			}
		}
		return $map;
	}

	/**
	 * Comma/newline separated list → array of trimmed, non-empty values.
	 *
	 * @param string $raw Raw value.
	 * @return array
	 */
	public static function to_list( $raw ) {
		return array_values( array_filter( array_map( 'trim', preg_split( '/[\s,]+/', (string) $raw ) ) ) );
	}

	/**
	 * Sanitize the full option array submitted from the settings page.
	 *
	 * @param mixed $in Raw input.
	 * @return array
	 */
	public static function sanitize( $in ) {
		// WP runs the sanitize callback twice when the option is first created; reuse the result.
		static $done = null;
		if ( null !== $done ) {
			return $done;
		}
		$in   = is_array( $in ) ? $in : array(); // options.php already unslashed it.
		$d    = self::defaults();
		$prev = self::get();
		$raw  = current_user_can( 'unfiltered_html' );
		$out  = array();

		$text = array( 'policy_text', 'btn_accept', 'btn_reject', 'btn_settings', 'btn_save', 'prefs_title', 'necessary_label', 'always_active', 'fab_label', 'dns_text' );
		foreach ( $text as $k ) {
			$out[ $k ] = isset( $in[ $k ] ) ? sanitize_text_field( $in[ $k ] ) : $d[ $k ];
		}
		foreach ( array( 'message', 'prefs_intro', 'necessary_desc', 'gpc_text' ) as $k ) {
			$out[ $k ] = isset( $in[ $k ] ) ? wp_kses_post( $in[ $k ] ) : $d[ $k ];
		}
		foreach ( array( 'enabled', 'reject_in_banner', 'fab', 'gcm', 'gcm_redaction', 'gcm_passthrough', 'zaraz', 'geo', 'geo_tz', 'geo_europe', 'gpc', 'idxb_compat', 'reload_on_revoke' ) as $k ) {
			$out[ $k ] = empty( $in[ $k ] ) ? 0 : 1;
		}
		foreach ( array( 'color_bg', 'color_text', 'color_btn', 'color_btn_text', 'color_link' ) as $k ) {
			$c         = isset( $in[ $k ] ) ? sanitize_hex_color( $in[ $k ] ) : '';
			$out[ $k ] = $c ? $c : $d[ $k ];
		}

		foreach ( array( 'idxb_crm_cat', 'idxb_gtm_cat' ) as $k ) {
			$out[ $k ] = isset( $in[ $k ] ) && in_array( $in[ $k ], array_merge( array( 'necessary' ), self::CATS ), true ) ? $in[ $k ] : 'marketing';
		}
		$out['layout']       = isset( $in['layout'] ) && in_array( $in['layout'], array( 'bar', 'box-left', 'box-right' ), true ) ? $in['layout'] : 'bar';
		$out['fab_position'] = isset( $in['fab_position'] ) && 'right' === $in['fab_position'] ? 'right' : 'left';
		$out['geo_unknown']  = isset( $in['geo_unknown'] ) && in_array( $in['geo_unknown'], array( 'tz', 'show', 'hide' ), true ) ? $in['geo_unknown'] : 'tz';
		$out['policy_url']   = isset( $in['policy_url'] ) ? esc_url_raw( $in['policy_url'] ) : '';
		$out['radius']       = isset( $in['radius'] ) ? min( 30, max( 0, absint( $in['radius'] ) ) ) : $d['radius'];
		$out['cookie_days']  = isset( $in['cookie_days'] ) ? min( 395, max( 1, absint( $in['cookie_days'] ) ) ) : $d['cookie_days'];

		$name               = isset( $in['cookie_name'] ) ? preg_replace( '/[^A-Za-z0-9_\-]/', '', $in['cookie_name'] ) : '';
		$out['cookie_name'] = $name ? $name : $d['cookie_name'];
		$geo_ck             = isset( $in['geo_cookie'] ) ? preg_replace( '/[^A-Za-z0-9_\-]/', '', $in['geo_cookie'] ) : '';
		$out['geo_cookie']  = $geo_ck ? $geo_ck : $d['geo_cookie'];
		$out['cookie_domain'] = isset( $in['cookie_domain'] ) ? preg_replace( '/[^A-Za-z0-9.\-]/', '', $in['cookie_domain'] ) : '';

		$countries            = isset( $in['geo_countries'] ) ? self::to_list( strtoupper( $in['geo_countries'] ) ) : array();
		$countries            = array_filter( $countries, static function ( $c ) { return (bool) preg_match( '/^[A-Z]{2}(-[A-Z0-9]{1,3})?$/', $c ); } );
		$out['geo_countries'] = $countries ? implode( ',', $countries ) : $d['geo_countries'];

		$handles = isset( $in['handles'] ) ? self::parse_handles( $in['handles'] ) : array();
		$lines   = array();
		foreach ( $handles as $h => $c ) {
			$lines[] = preg_replace( '/[^A-Za-z0-9_\-.]/', '', $h ) . ':' . $c;
		}
		$out['handles'] = implode( "\n", $lines );

		// Code fields: raw HTML/JS only for users allowed to post unfiltered HTML.
		foreach ( array( 'necessary_head', 'necessary_body' ) as $k ) {
			$out[ $k ] = $raw && isset( $in[ $k ] ) ? (string) $in[ $k ] : $prev[ $k ];
		}

		$out['cats'] = array();
		foreach ( self::CATS as $c ) {
			$ci = isset( $in['cats'][ $c ] ) && is_array( $in['cats'][ $c ] ) ? $in['cats'][ $c ] : array();
			$out['cats'][ $c ] = array(
				'enabled' => empty( $ci['enabled'] ) ? 0 : 1,
				'label'   => isset( $ci['label'] ) && '' !== trim( $ci['label'] ) ? sanitize_text_field( $ci['label'] ) : $d['cats'][ $c ]['label'],
				'desc'    => isset( $ci['desc'] ) ? wp_kses_post( $ci['desc'] ) : $d['cats'][ $c ]['desc'],
				'head'    => $raw && isset( $ci['head'] ) ? (string) $ci['head'] : $prev['cats'][ $c ]['head'],
				'body'    => $raw && isset( $ci['body'] ) ? (string) $ci['body'] : $prev['cats'][ $c ]['body'],
				'delete'  => isset( $ci['delete'] ) ? implode( "\n", array_map( static function ( $n ) { return preg_replace( '/[^A-Za-z0-9_\-.]/', '', $n ); }, self::to_list( $ci['delete'] ) ) ) : '',
				'zaraz'   => isset( $ci['zaraz'] ) ? preg_replace( '/[^A-Za-z0-9_\-]/', '', $ci['zaraz'] ) : '',
			);
		}

		$out['revision'] = max( 1, (int) $prev['revision'] );
		if ( ! empty( $_POST['icc_bump_revision'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification -- options.php already verified the settings nonce.
			++$out['revision'];
		}

		self::flush();
		$done = $out;
		return $out;
	}
}
