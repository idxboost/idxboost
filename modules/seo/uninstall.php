<?php
defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

global $wpdb;

// robots.txt is left exactly as published (never deleted).

foreach ( array( 'idxb_seo_settings', 'idxb_seo_cache_ver', 'idxb_seo_robots_state', 'idxb_seo_idx_state', 'idxb_seo_db_ver', 'idxb_seo_rewrite_ver', 'idxb_seo_robots_seeded', 'idxb_seo_robots_backup', 'idxb_seo_robots_written' ) as $idxb_opt ) {
	delete_option( $idxb_opt );
}
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}idxb_seo_listings" ); // phpcs:ignore
$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '\_transient\_idxb\_seo\_%' OR option_name LIKE '\_transient\_timeout\_idxb\_seo\_%'" ); // phpcs:ignore
$wpdb->query( "DELETE FROM {$wpdb->postmeta} WHERE meta_key = '_idxb_seo_exclude'" ); // phpcs:ignore
wp_clear_scheduled_hook( 'idxb_seo_idx_sync' );
wp_clear_scheduled_hook( 'idxb_seo_idx_sync_batch' );
