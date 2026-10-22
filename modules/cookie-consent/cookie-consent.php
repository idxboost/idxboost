<?php
/**
 * IDXBoost module: Cookie Consent (GDPR / CCPA).
 *
 * Self-contained copy of the IDX Cookie Consent plugin, loaded from idxboost.php.
 * It does not change any IDXBoost logic: IDXBoost trackers are only gated through
 * hook wrappers (see includes/class-icc-idxboost.php).
 *
 * Disabled by default — turn it on in IDX Boost → Cookie Consent.
 * If the standalone "IDX Cookie Consent" plugin is active, this module stays off.
 *
 * @package IDX_Cookie_Consent
 */

defined( 'ABSPATH' ) || exit;

if ( defined( 'ICC_VERSION' ) ) {
	return; // Standalone plugin already loaded.
}

define( 'ICC_MODULE', true );
add_filter( 'icc_default_enabled', '__return_false' );

require_once __DIR__ . '/idx-cookie-consent.php';
