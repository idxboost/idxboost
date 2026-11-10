<?php
defined( 'ABSPATH' ) || exit;

interface IDXB_SEO_Provider {

	/** File prefix: "{key}-sitemap{n}.xml". */
	public function key(): string;

	/** Human label for the admin. */
	public function label(): string;

	/**
	 * Number of URLs and per-page lastmod. Returns list of [ 'page' => int, 'count' => int, 'lastmod' => int ].
	 */
	public function pages( array $settings, array $ctx ): array;

	/**
	 * URLs for one page. Returns list of [ 'loc' => string, 'lastmod' => int, 'images' => string[] ].
	 */
	public function entries( array $settings, array $ctx, int $page ): array;
}

/**
 * Shared pagination helper: list of timestamps (sorted asc) -> page summaries.
 */
function idxb_seo_paginate_summary( array $timestamps, int $per ): array {
	$pages = array();
	$total = count( $timestamps );
	for ( $i = 0, $n = 1; $i < $total; $i += $per, $n++ ) {
		$chunk   = array_slice( $timestamps, $i, $per );
		$pages[] = array(
			'page'    => $n,
			'count'   => count( $chunk ),
			'lastmod' => (int) max( $chunk ),
		);
	}
	return $pages;
}

function idxb_seo_gmt_ts( $mysql_gmt ): int {
	if ( ! $mysql_gmt || '0000-00-00 00:00:00' === $mysql_gmt ) {
		return time();
	}
	$ts = strtotime( $mysql_gmt . ' UTC' );
	return $ts ? $ts : time();
}
