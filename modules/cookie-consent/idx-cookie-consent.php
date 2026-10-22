<?php
/**
 * Plugin Name:       IDX Cookie Consent
 * Description:       Lightweight GDPR/CCPA cookie consent banner. No jQuery, no web fonts, no AJAX on page load, page-cache safe. Supports Google Consent Mode v2, Cloudflare geolocation and Zaraz.
 * Version:           1.5.2
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            IDXBoost
 * License:           GPL-2.0-or-later
 * Text Domain:       idx-cookie-consent
 *
 * @package IDX_Cookie_Consent
 */

defined( 'ABSPATH' ) || exit;

// Loaded twice (standalone plugin + IDXBoost module): the first one wins.
if ( defined( 'ICC_VERSION' ) ) {
	return;
}

define( 'ICC_VERSION', '1.5.2' );
define( 'ICC_FILE', __FILE__ );
define( 'ICC_DIR', plugin_dir_path( __FILE__ ) );

require_once ICC_DIR . 'includes/class-icc-options.php';
require_once ICC_DIR . 'includes/class-icc-frontend.php';
require_once ICC_DIR . 'includes/class-icc-admin.php';
require_once ICC_DIR . 'includes/class-icc-idxboost.php';

add_action(
	'plugins_loaded',
	static function () {
		if ( ! defined( 'ICC_MODULE' ) ) {
			load_plugin_textdomain( 'idx-cookie-consent', false, dirname( plugin_basename( ICC_FILE ) ) . '/languages' );
		}
		if ( is_admin() ) {
			new ICC_Admin();
		} else {
			new ICC_Frontend();
		}
	}
);

add_action(
	'init',
	static function () {
		add_shortcode( 'icc_settings', array( 'ICC_Frontend', 'shortcode' ) );
		add_shortcode( 'icc_do_not_sell', array( 'ICC_Frontend', 'shortcode_dns' ) );
	}
);
