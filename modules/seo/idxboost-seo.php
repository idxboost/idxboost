<?php
/**
 * Plugin Name:       IDXBoost SEO
 * Description:       XML sitemaps (including IDX property detail pages) and a robots.txt editor for IDXBoost sites.
 * Version:           1.4.0
 * Requires at least: 6.0
 * Requires PHP:      8.1
 * Author:            IDXBoost
 * Text Domain:       idxboost-seo
 */

defined( 'ABSPATH' ) || exit;

// Loaded twice (standalone plugin + IDXBoost module): the first one wins.
if ( defined( 'IDXB_SEO_VERSION' ) ) {
	return;
}

define( 'IDXB_SEO_VERSION', '1.4.0' );
define( 'IDXB_SEO_FILE', __FILE__ );
define( 'IDXB_SEO_DIR', plugin_dir_path( __FILE__ ) );
define( 'IDXB_SEO_URL', plugin_dir_url( __FILE__ ) );

require_once IDXB_SEO_DIR . 'includes/class-settings.php';
require_once IDXB_SEO_DIR . 'includes/class-cache.php';
require_once IDXB_SEO_DIR . 'includes/providers/interface-provider.php';
require_once IDXB_SEO_DIR . 'includes/providers/class-provider-post-type.php';
require_once IDXB_SEO_DIR . 'includes/providers/class-provider-taxonomy.php';
require_once IDXB_SEO_DIR . 'includes/providers/class-provider-author.php';
require_once IDXB_SEO_DIR . 'includes/providers/class-provider-idx-property.php';
require_once IDXB_SEO_DIR . 'includes/class-sitemap-builder.php';
require_once IDXB_SEO_DIR . 'includes/class-sitemap-router.php';
require_once IDXB_SEO_DIR . 'includes/class-robots.php';
require_once IDXB_SEO_DIR . 'includes/class-idx-sync.php';
require_once IDXB_SEO_DIR . 'includes/class-conflicts.php';
require_once IDXB_SEO_DIR . 'includes/class-rest.php';
require_once IDXB_SEO_DIR . 'includes/class-admin.php';

add_action(
	'init',
	static function () {
		load_plugin_textdomain( 'idxboost-seo', false, dirname( plugin_basename( IDXB_SEO_FILE ) ) . '/languages' );
	}
);

/** Inside IDXBoost the module is opt-in (it replaces sitemaps and robots.txt), as a standalone plugin it is always on. */
function idxb_seo_is_active(): bool {
	return ! defined( 'IDXB_SEO_MODULE' ) || (bool) get_option( 'idxb_seo_module_enabled', false );
}

if ( idxb_seo_is_active() ) {
	IDXB_SEO_Cache::init();
	IDXB_SEO_Sitemap_Router::init();
	IDXB_SEO_Robots::init();
	IDXB_SEO_IDX_Sync::init();
	IDXB_SEO_Conflicts::init();
	IDXB_SEO_REST::init();
	IDXB_SEO_Admin::init();
} else {
	IDXB_SEO_Admin::init_off();
}
if ( defined( 'IDXB_SEO_MODULE' ) ) {
	add_action( 'admin_post_idxb_seo_module', 'idxb_seo_module_toggle' );
} else {
	register_activation_hook( __FILE__, 'idxb_seo_activate' );
	register_deactivation_hook( __FILE__, 'idxb_seo_deactivate' );
}

/** IDXBoost module on/off switch (runs the same steps as plugin activation/deactivation). */
function idxb_seo_module_toggle() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Not allowed', 'idxboost-seo' ), 403 );
	}
	check_admin_referer( 'idxb_seo_module' );
	$on = ! empty( $_POST['enable'] );
	if ( $on ) {
		update_option( 'idxb_seo_module_enabled', 1, true );
		idxb_seo_activate();
	} else {
		idxb_seo_deactivate();
		update_option( 'idxb_seo_module_enabled', 0, true );
	}
	wp_safe_redirect( admin_url( 'admin.php?page=idxb-seo-sitemap&idxb_module=' . ( $on ? 'on' : 'off' ) ) );
	exit;
}

function idxb_seo_activate() {
	IDXB_SEO_IDX_Sync::install_table();
	IDXB_SEO_Sitemap_Router::add_rules();
	flush_rewrite_rules( false );
	update_option( 'idxb_seo_rewrite_ver', IDXB_SEO_VERSION );
	IDXB_SEO_IDX_Sync::reschedule();
	IDXB_SEO_Robots::heal_orphan_backup();
	IDXB_SEO_Robots::seed_from_site();
	IDXB_SEO_Robots::apply_mode();
}

function idxb_seo_deactivate() {
	// robots.txt stays exactly as published: the plugin never deletes it.
	// Only sites left without one by older versions (renamed backups) get their original back.
	IDXB_SEO_Robots::restore_backup();
	IDXB_SEO_IDX_Sync::unschedule();
	// Our rules are still registered during this request; force WP to rebuild them on the next one.
	delete_option( 'rewrite_rules' );
	delete_option( 'idxb_seo_rewrite_ver' );
}
