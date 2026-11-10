<?php
defined( 'ABSPATH' ) || exit;

class IDXB_SEO_Provider_Taxonomy implements IDXB_SEO_Provider {

	private $tax;
	private static $rows = array();

	public function __construct( string $taxonomy ) {
		$this->tax = $taxonomy;
	}

	public function key(): string {
		return $this->tax;
	}

	public function label(): string {
		$o = get_taxonomy( $this->tax );
		return $o ? $o->labels->name : $this->tax;
	}

	/** List of [ WP_Term, ts ] sorted by lastmod asc. */
	private function rows( array $settings, array $ctx ): array {
		$memo = $this->tax . '|' . $ctx['hash'];
		if ( isset( self::$rows[ $memo ] ) ) {
			return self::$rows[ $memo ];
		}
		global $wpdb;
		$stats = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT tt.term_id AS term_id, MAX(p.post_modified_gmt) AS m, COUNT(p.ID) AS c
				 FROM {$wpdb->term_taxonomy} tt
				 INNER JOIN {$wpdb->term_relationships} tr ON tr.term_taxonomy_id = tt.term_taxonomy_id
				 INNER JOIN {$wpdb->posts} p ON p.ID = tr.object_id
				 WHERE tt.taxonomy = %s AND p.post_status = 'publish' AND p.post_password = ''
				 GROUP BY tt.term_id",
				$this->tax
			),
			OBJECT_K
		);

		$terms = get_terms(
			array(
				'taxonomy'               => $this->tax,
				'hide_empty'             => false,
				'update_term_meta_cache' => true,
			)
		);
		$yoast = get_option( 'wpseo_taxonomy_meta' );
		$rows  = array();
		foreach ( is_array( $terms ) ? $terms : array() as $t ) {
			if ( isset( $ctx['excluded_terms'][ $t->term_id ] ) ) {
				continue;
			}
			$has = isset( $stats[ $t->term_id ] ) && (int) $stats[ $t->term_id ]->c > 0;
			if ( $settings['sitemap']['excludeEmptyTerms'] && ! $has ) {
				continue;
			}
			if ( ( $yoast[ $this->tax ][ $t->term_id ]['wpseo_noindex'] ?? '' ) === 'noindex' ) {
				continue;
			}
			$rm = get_term_meta( $t->term_id, 'rank_math_robots', true );
			if ( is_array( $rm ) && in_array( 'noindex', $rm, true ) ) {
				continue;
			}
			$rows[] = array( $t, $has ? idxb_seo_gmt_ts( $stats[ $t->term_id ]->m ) : time() );
		}
		usort( $rows, fn( $a, $b ) => $a[1] <=> $b[1] ?: $a[0]->term_id <=> $b[0]->term_id );
		self::$rows[ $memo ] = $rows;
		return $rows;
	}

	public function pages( array $settings, array $ctx ): array {
		return idxb_seo_paginate_summary( array_map( fn( $r ) => $r[1], $this->rows( $settings, $ctx ) ), $ctx['per'] );
	}

	public function entries( array $settings, array $ctx, int $page ): array {
		$out = array();
		foreach ( array_slice( $this->rows( $settings, $ctx ), ( $page - 1 ) * $ctx['per'], $ctx['per'] ) as $r ) {
			$link = get_term_link( $r[0] );
			if ( is_wp_error( $link ) ) {
				continue;
			}
			$out[] = array( 'loc' => $link, 'lastmod' => $r[1], 'images' => array() );
		}
		return $out;
	}
}
