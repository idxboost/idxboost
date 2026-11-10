<?php
/**
 * IDXBoost module: SEO (XML sitemaps + robots.txt).
 *
 * Self-contained copy of the IDXBoost SEO plugin, loaded from idxboost.php.
 * Disabled by default — turn it on in IDX Boost → SEO: Sitemap & Robots.
 * If the standalone "IDXBoost SEO" plugin is active, this module stays off.
 *
 * @package IDXBoost_SEO
 */

defined( 'ABSPATH' ) || exit;

if ( defined( 'IDXB_SEO_VERSION' ) ) {
	return; // Standalone plugin already loaded.
}

define( 'IDXB_SEO_MODULE', true );

require_once __DIR__ . '/idxboost-seo.php';
