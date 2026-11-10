<?php
defined( 'ABSPATH' ) || exit;

/**
 * Property detail pages coming from the IDX service, read from the local table filled by IDXB_SEO_IDX_Sync.
 */
class IDXB_SEO_Provider_IDX_Property implements IDXB_SEO_Provider {

	const KEY = 'idx-property';

	private static $ts = null;

	public function key(): string {
		return self::KEY;
	}

	public function label(): string {
		return __( 'Properties (IDX)', 'idxboost-seo' );
	}

	private function timestamps(): array {
		if ( null === self::$ts ) {
			global $wpdb;
			$table    = IDXB_SEO_IDX_Sync::table();
			$col      = $wpdb->get_col( "SELECT lastmod FROM {$table} ORDER BY lastmod ASC, id ASC" ); // phpcs:ignore
			self::$ts = array_map( 'idxb_seo_gmt_ts', (array) $col );
		}
		return self::$ts;
	}

	public function pages( array $settings, array $ctx ): array {
		if ( ! IDXB_SEO_IDX_Sync::table_exists() ) {
			return array();
		}
		return idxb_seo_paginate_summary( $this->timestamps(), $ctx['per'] );
	}

	public function entries( array $settings, array $ctx, int $page ): array {
		global $wpdb;
		$table = IDXB_SEO_IDX_Sync::table();
		$rows  = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT url, lastmod, images FROM {$table} ORDER BY lastmod ASC, id ASC LIMIT %d OFFSET %d", // phpcs:ignore
				$ctx['per'],
				( $page - 1 ) * $ctx['per']
			)
		);
		$out = array();
		foreach ( (array) $rows as $r ) {
			$images = array();
			if ( $settings['sitemap']['includeImages'] && $r->images ) {
				$images = array_values( array_filter( (array) json_decode( $r->images, true ), 'is_string' ) );
			}
			$out[] = array( 'loc' => $r->url, 'lastmod' => idxb_seo_gmt_ts( $r->lastmod ), 'images' => $images );
		}
		return $out;
	}
}
