<?php
defined( 'ABSPATH' ) || exit;

class IDXB_SEO_Provider_Post_Type implements IDXB_SEO_Provider {

	private $pt;
	private static $rows = array();

	public function __construct( string $post_type ) {
		$this->pt = $post_type;
	}

	public function key(): string {
		return $this->pt;
	}

	public function label(): string {
		$o = get_post_type_object( $this->pt );
		return $o ? $o->labels->name : $this->pt;
	}

	/** Sorted (lastmod asc) list of [ id, ts ]; id 0 = homepage. */
	private function rows( array $settings, array $ctx ): array {
		$memo = $this->pt . '|' . $ctx['hash'];
		if ( isset( self::$rows[ $memo ] ) ) {
			return self::$rows[ $memo ];
		}
		global $wpdb;
		$res  = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT ID, post_modified_gmt FROM {$wpdb->posts}
				 WHERE post_type = %s AND post_status = 'publish' AND post_password = ''
				 ORDER BY post_modified_gmt ASC, ID ASC",
				$this->pt
			)
		);
		$rows = array();
		foreach ( (array) $res as $r ) {
			$id = (int) $r->ID;
			if ( isset( $ctx['excluded_ids'][ $id ] ) ) {
				continue;
			}
			$rows[] = array( $id, idxb_seo_gmt_ts( $r->post_modified_gmt ) );
		}

		if ( 'page' === $this->pt ) {
			// Homepage first, like Yoast. A static front page is represented by the home URL instead of its permalink.
			$rows = array_values( array_filter( $rows, fn( $r ) => $r[0] !== $ctx['front_page_id'] ) );
			array_unshift( $rows, array( 0, $ctx['home_lastmod'] ) );
		}

		self::$rows[ $memo ] = $rows;
		return $rows;
	}

	public function pages( array $settings, array $ctx ): array {
		$rows = $this->rows( $settings, $ctx );
		if ( ! $rows ) {
			return array();
		}
		// Keep the homepage at the top of page 1; lastmod per page is the max inside it.
		$ts = array_map( fn( $r ) => $r[1], $rows );
		return idxb_seo_paginate_summary( $ts, $ctx['per'] );
	}

	public function entries( array $settings, array $ctx, int $page ): array {
		$rows  = array_slice( $this->rows( $settings, $ctx ), ( $page - 1 ) * $ctx['per'], $ctx['per'] );
		$ids   = array_filter( array_map( fn( $r ) => $r[0], $rows ) );
		$imgs  = $settings['sitemap']['includeImages'];
		if ( $ids ) {
			_prime_post_caches( $ids, false, true );
			if ( $imgs ) {
				$thumbs = array_filter( array_map( fn( $id ) => (int) get_post_thumbnail_id( $id ), $ids ) );
				if ( $thumbs ) {
					_prime_post_caches( $thumbs, false, true );
				}
			}
		}

		$out = array();
		foreach ( $rows as $r ) {
			if ( 0 === $r[0] ) {
				$out[] = array( 'loc' => home_url( '/' ), 'lastmod' => $r[1], 'images' => array() );
				continue;
			}
			$loc = get_permalink( $r[0] );
			if ( ! $loc ) {
				continue;
			}
			$images = array();
			if ( $imgs ) {
				$thumb = get_post_thumbnail_id( $r[0] );
				if ( $thumb ) {
					$src = wp_get_attachment_image_url( $thumb, 'full' );
					if ( $src ) {
						$images[] = $src;
					}
				}
				$images = (array) apply_filters( 'idxb_seo_post_images', $images, $r[0] );
			}
			$entry = apply_filters(
				'idxb_seo_post_entry',
				array( 'loc' => $loc, 'lastmod' => $r[1], 'images' => $images ),
				$r[0]
			);
			if ( $entry ) {
				$out[] = $entry;
			}
		}
		return $out;
	}
}
