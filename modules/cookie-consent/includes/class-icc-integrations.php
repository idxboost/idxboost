<?php
/**
 * Integrations: tracking ID + category instead of pasting code (GA4, GTM, Google Ads, Meta Pixel, UET, Clarity, reCAPTCHA).
 *
 * @package IDX_Cookie_Consent
 */

defined( 'ABSPATH' ) || exit;

/**
 * Integration definitions, sanitizing and snippet output.
 */
class ICC_Integrations {

	/**
	 * Definitions: label, sub-label, ID pattern (empty = no ID), placeholder, default category (empty = no category).
	 *
	 * @return array
	 */
	public static function defs() {
		return array(
			'ga4'       => array( 'Google Analytics 4', '', '/^G-[A-Z0-9]{4,20}$/', 'G-XXXXXXXXXX', 'analytics' ),
			'gtm'       => array( 'Google Tag Manager', 'Standard implementation', '/^GTM-[A-Z0-9]{4,12}$/', 'GTM-XXXXXXX', 'analytics' ),
			'gtm_cm'    => array( 'Google Tag Manager', 'Consent Mode v2 [for advanced users]: GTM always loads and each tag follows Google Consent Mode', '/^GTM-[A-Z0-9]{4,12}$/', 'GTM-XXXXXXX', '' ),
			'gads'      => array( 'Google Ads', '', '/^AW-[0-9]{5,15}$/', 'AW-XXXXXXXXX', 'marketing' ),
			'meta'      => array( 'Meta Pixel', '(Formerly Facebook Pixel)', '/^[0-9]{5,20}$/', '123456789012345', 'marketing' ),
			'uet'       => array( 'Microsoft Advertising (UET)', 'Universal Event Tracking', '/^[0-9]{4,15}$/', '12345678', 'marketing' ),
			'clarity'   => array( 'Microsoft Clarity', 'Consent API v2 [requires Consent Mode enabled in the Clarity project]', '/^[a-z0-9]{6,20}$/', 'abcdef1234', 'analytics' ),
			'recaptcha' => array( 'Google reCAPTCHA', 'Blocks reCAPTCHA (enqueued by forms) until the visitor accepts the selected category', '', '', 'marketing' ),
		);
	}

	/**
	 * Default values.
	 *
	 * @return array
	 */
	public static function defaults() {
		$out = array();
		foreach ( self::defs() as $k => $d ) {
			$out[ $k ] = array(
				'on'  => 0,
				'id'  => '',
				'cat' => $d[4],
			);
		}
		return $out;
	}

	/**
	 * Saved values merged over defaults.
	 *
	 * @param mixed $saved Saved value.
	 * @return array
	 */
	public static function merge( $saved ) {
		$out = self::defaults();
		foreach ( $out as $k => $v ) {
			if ( isset( $saved[ $k ] ) && is_array( $saved[ $k ] ) ) {
				$out[ $k ] = array_merge( $v, $saved[ $k ] );
			}
		}
		return $out;
	}

	/**
	 * Sanitize the submitted integrations.
	 *
	 * @param mixed $in Raw input.
	 * @return array
	 */
	public static function sanitize( $in ) {
		$in   = is_array( $in ) ? $in : array();
		$cats = array_merge( array( 'necessary' ), ICC_Options::CATS );
		$out  = array();
		foreach ( self::defs() as $k => $d ) {
			$r  = isset( $in[ $k ] ) && is_array( $in[ $k ] ) ? $in[ $k ] : array();
			$id = isset( $r['id'] ) ? preg_replace( '/[^A-Za-z0-9\-]/', '', (string) $r['id'] ) : '';
			$id = 'clarity' === $k ? strtolower( $id ) : strtoupper( $id );
			$on = empty( $r['on'] ) ? 0 : 1;
			if ( $on && $d[2] && ! preg_match( $d[2], $id ) ) {
				$on = 0;
				add_settings_error( ICC_Options::KEY, 'icc_int_' . $k, sprintf( /* translators: 1: integration, 2: example ID */ __( '%1$s was not enabled: the tracking ID is not valid (example: %2$s).', 'idx-cookie-consent' ), $d[0], $d[3] ) );
			}
			$out[ $k ] = array(
				'on'  => $on,
				'id'  => $id,
				'cat' => $d[4] && isset( $r['cat'] ) && in_array( $r['cat'], $cats, true ) ? $r['cat'] : $d[4],
			);
		}
		if ( $out['gtm']['on'] && $out['gtm_cm']['on'] ) {
			$out['gtm']['on'] = 0;
			add_settings_error( ICC_Options::KEY, 'icc_int_gtm', __( 'Only one Google Tag Manager implementation can be active: kept "Consent Mode v2".', 'idx-cookie-consent' ) );
		}
		return $out;
	}

	/**
	 * Active integrations whose category is offered (or "necessary").
	 *
	 * @param array $o Options.
	 * @return array key => array( id, cat ).
	 */
	public static function active( $o ) {
		$out = array();
		foreach ( $o['int'] as $k => $v ) {
			if ( empty( $v['on'] ) ) {
				continue;
			}
			$cat = $v['cat'];
			if ( $cat && 'necessary' !== $cat && empty( $o['cats'][ $cat ]['enabled'] ) ) {
				continue; // Category not offered to visitors: nothing could ever allow it.
			}
			$out[ $k ] = array( $v['id'], $cat );
		}
		return $out;
	}

	/**
	 * GTM loader.
	 *
	 * @param string $id Container ID.
	 * @return string
	 */
	private static function gtm( $id ) {
		return "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s);j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','" . esc_js( $id ) . "');</script>";
	}

	/**
	 * Code that must load regardless of consent (GTM in Consent Mode v2). Printed right after the Consent Mode defaults.
	 *
	 * @param array $o Options.
	 * @return string
	 */
	public static function always( $o ) {
		$a = self::active( $o );
		return isset( $a['gtm_cm'] ) ? self::gtm( $a['gtm_cm'][0] ) . "\n" : '';
	}

	/**
	 * Head code grouped by category (category => html). "necessary" runs without consent.
	 *
	 * @param array $o Options.
	 * @return array
	 */
	public static function head( $o ) {
		$by    = array();
		$gtags = array();
		foreach ( self::active( $o ) as $k => $v ) {
			list( $id, $cat ) = $v;
			$code             = '';
			switch ( $k ) {
				case 'ga4':
				case 'gads':
					$gtags[ $cat ][] = $id; // One gtag.js per category, several IDs.
					break;
				case 'gtm':
					$code = self::gtm( $id );
					break;
				case 'meta':
					$code = "<script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init','" . esc_js( $id ) . "');fbq('track','PageView');</script>";
					break;
				case 'uet':
					$code = "<script>(function(w,d,t,r,u){var f,n,i;w[u]=w[u]||[],f=function(){var o={ti:'" . esc_js( $id ) . "',enableAutoSpaTracking:true};o.q=w[u],w[u]=new UET(o),w[u].push('pageLoad')},n=d.createElement(t),n.src=r,n.async=1,n.onload=n.onreadystatechange=function(){var s=this.readyState;s&&s!=='loaded'&&s!=='complete'||(f(),n.onload=n.onreadystatechange=null)},i=d.getElementsByTagName(t)[0],i.parentNode.insertBefore(n,i)})(window,document,'script','https://bat.bing.com/bat.js','uetq');</script>";
					break;
				case 'clarity':
					// Consent API v2: send the current choice on load and on every change.
					$code = "<script>(function(c,l,a,r,i,t,y){c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};t=l.createElement(r);t.async=1;t.src='https://www.clarity.ms/tag/'+i;y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y)})(window,document,'clarity','script','" . esc_js( $id ) . "');"
						. "(function(){function s(k){k=k||{};clarity('consentv2',{ad_Storage:k.marketing?'granted':'denied',analytics_Storage:k.analytics?'granted':'denied'})}s(window.ICC&&ICC.consent);document.addEventListener('icc:consent',function(e){s(e.detail.consent)})})();</script>";
					break;
			}
			if ( $code ) {
				$by[ $cat ] = ( isset( $by[ $cat ] ) ? $by[ $cat ] : '' ) . $code;
			}
		}
		foreach ( $gtags as $cat => $ids ) {
			$code = '<script async src="https://www.googletagmanager.com/gtag/js?id=' . esc_attr( $ids[0] ) . '"></script><script>window.dataLayer=window.dataLayer||[];window.gtag=window.gtag||function(){dataLayer.push(arguments)};gtag(\'js\',new Date());';
			foreach ( $ids as $id ) {
				$code .= "gtag('config','" . esc_js( $id ) . "');";
			}
			$by[ $cat ] = $code . '</script>' . ( isset( $by[ $cat ] ) ? $by[ $cat ] : '' );
		}
		return $by;
	}

	/**
	 * Category for reCAPTCHA blocking, or '' when off / always allowed.
	 *
	 * @param array $o Options.
	 * @return string
	 */
	public static function recaptcha_cat( $o ) {
		$a = self::active( $o );
		return isset( $a['recaptcha'] ) && 'necessary' !== $a['recaptcha'][1] ? $a['recaptcha'][1] : '';
	}
}
