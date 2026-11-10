<?php
defined( 'ABSPATH' ) || exit;

class IDXB_SEO_Provider_Author implements IDXB_SEO_Provider {

	private static $rows = array();

	public function key(): string {
		return 'author';
	}

	public function label(): string {
		return __( 'Authors', 'idxboost-seo' );
	}

	/** Post types that count as "author content" (enabled ones, without pages/attachments). */
	private function content_types( array $settings ): array {
		$types = array();
		foreach ( get_post_types( array( 'public' => true ) ) as $pt ) {
			if ( in_array( $pt, array( 'page', 'attachment' ), true ) ) {
				continue;
			}
			if ( IDXB_SEO_Settings::post_type_enabled( $settings, $pt ) ) {
				$types[] = $pt;
			}
		}
		return $types;
	}

	private function rows( array $settings, array $ctx ): array {
		if ( isset( self::$rows[ $ctx['hash'] ] ) ) {
			return self::$rows[ $ctx['hash'] ];
		}
		global $wpdb;
		$types = $this->content_types( $settings );
		$stats = array();
		if ( $types ) {
			$in    = implode( ',', array_fill( 0, count( $types ), '%s' ) );
			$stats = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT post_author, MAX(post_modified_gmt) AS m, COUNT(ID) AS c FROM {$wpdb->posts}
					 WHERE post_status = 'publish' AND post_password = '' AND post_type IN ($in)
					 GROUP BY post_author",
					$types
				),
				OBJECT_K
			);
		}

		// Only users who can write content: IDX sites register leads as subscribers, never list those.
		if ( $settings['sitemap']['authors']['excludeNoPosts'] ) {
			$ids = array_map( 'intval', array_keys( $stats ) );
		} else {
			$ids = array_map( 'intval', get_users( array( 'capability' => 'edit_posts', 'fields' => 'ID' ) ) );
			$ids = array_values( array_unique( array_merge( $ids, array_map( 'intval', array_keys( $stats ) ) ) ) );
		}

		$rows = array();
		if ( $ids ) {
			cache_users( $ids );
			foreach ( $ids as $uid ) {
				$user = get_userdata( $uid );
				if ( ! $user || ! user_can( $user, 'edit_posts' ) ) {
					continue;
				}
				if ( 'on' === get_user_meta( $uid, 'wpseo_noindex_author', true ) || get_user_meta( $uid, 'idxb_seo_exclude', true ) ) {
					continue;
				}
				$rows[] = array( $uid, isset( $stats[ $uid ] ) ? idxb_seo_gmt_ts( $stats[ $uid ]->m ) : time() );
			}
		}
		usort( $rows, fn( $a, $b ) => $a[1] <=> $b[1] ?: $a[0] <=> $b[0] );
		self::$rows[ $ctx['hash'] ] = $rows;
		return $rows;
	}

	public function pages( array $settings, array $ctx ): array {
		return idxb_seo_paginate_summary( array_map( fn( $r ) => $r[1], $this->rows( $settings, $ctx ) ), $ctx['per'] );
	}

	public function entries( array $settings, array $ctx, int $page ): array {
		$out = array();
		foreach ( array_slice( $this->rows( $settings, $ctx ), ( $page - 1 ) * $ctx['per'], $ctx['per'] ) as $r ) {
			$out[] = array( 'loc' => get_author_posts_url( $r[0] ), 'lastmod' => $r[1], 'images' => array() );
		}
		return $out;
	}
}
