<?php
defined( 'ABSPATH' ) || exit;

/**
 * Versioned transient cache. Any content change bumps the version, so stale entries simply expire.
 */
class IDXB_SEO_Cache {

	const VERSION_OPTION = 'idxb_seo_cache_ver';
	const TTL            = 12 * HOUR_IN_SECONDS;

	private static $bumped = false;

	public static function init() {
		add_action( 'save_post', array( __CLASS__, 'on_save_post' ), 10, 2 );
		add_action( 'deleted_post', array( __CLASS__, 'bump' ) );
		add_action( 'transition_post_status', array( __CLASS__, 'on_transition' ), 10, 3 );
		add_action( 'created_term', array( __CLASS__, 'bump' ) );
		add_action( 'edited_term', array( __CLASS__, 'bump' ) );
		add_action( 'delete_term', array( __CLASS__, 'bump' ) );
		add_action( 'profile_update', array( __CLASS__, 'bump' ) );
		add_action( 'user_register', array( __CLASS__, 'bump' ) );
		add_action( 'deleted_user', array( __CLASS__, 'bump' ) );
		add_action( 'update_option_permalink_structure', array( __CLASS__, 'bump' ) );
		add_action( 'update_option_show_on_front', array( __CLASS__, 'bump' ) );
		add_action( 'update_option_page_on_front', array( __CLASS__, 'bump' ) );
	}

	public static function on_save_post( $post_id, $post ) {
		if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
			return;
		}
		if ( 'publish' === $post->post_status ) {
			self::bump();
		}
	}

	public static function on_transition( $new, $old ) {
		if ( $new !== $old && ( 'publish' === $new || 'publish' === $old ) ) {
			self::bump();
		}
	}

	public static function version(): string {
		$v = get_option( self::VERSION_OPTION );
		if ( ! $v ) {
			$v = (string) time();
			update_option( self::VERSION_OPTION, $v, true );
		}
		return (string) $v;
	}

	public static function bump() {
		if ( self::$bumped ) {
			return; // once per request is enough
		}
		self::$bumped = true;
		update_option( self::VERSION_OPTION, uniqid( '', true ), true );
	}

	private static function key( string $name ): string {
		return 'idxb_seo_' . md5( self::version() . '|' . $name );
	}

	public static function get( string $name ) {
		return get_transient( self::key( $name ) );
	}

	public static function set( string $name, $value ) {
		set_transient( self::key( $name ), $value, self::TTL );
	}

	/** Cache-through helper. */
	public static function remember( string $name, callable $fn ) {
		$hit = self::get( $name );
		if ( false !== $hit ) {
			return $hit;
		}
		$value = $fn();
		self::set( $name, $value );
		return $value;
	}
}
