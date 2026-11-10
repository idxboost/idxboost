<?php
defined( 'ABSPATH' ) || exit;

class IDXB_SEO_Admin {

	const PAGES = array(
		'idxb-seo-sitemap' => 'sitemap',
		'idxb-seo-robots'  => 'robots',
		'idxb-seo-tools'   => 'tools',
	);

	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ), 20 ); // after IDXBoost builds its menu
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'assets' ) );
		add_action( 'add_meta_boxes', array( __CLASS__, 'metabox' ) );
		add_action( 'save_post', array( __CLASS__, 'save_metabox' ), 5 );
		if ( defined( 'IDXB_SEO_MODULE' ) ) {
			// Keep "IDX Boost > SEO" highlighted on the Robots/Tools tabs.
			add_filter( 'parent_file', fn( $f ) => self::current_route() && isset( $GLOBALS['admin_page_hooks']['flex-idx'] ) ? 'flex-idx' : $f );
			add_filter( 'submenu_file', fn( $f ) => self::current_route() ? 'idxb-seo-sitemap' : $f );
		} else {
			add_filter( 'plugin_action_links_' . plugin_basename( IDXB_SEO_FILE ), array( __CLASS__, 'action_links' ) );
		}
	}

	/** Module installed but switched off: only the page that turns it on. */
	public static function init_off() {
		add_action( 'admin_menu', array( __CLASS__, 'menu_off' ), 20 );
	}

	public static function menu_off() {
		global $admin_page_hooks;
		$parent = isset( $admin_page_hooks['flex-idx'] ) ? 'flex-idx' : 'options-general.php';
		add_submenu_page( $parent, __( 'SEO: Sitemap & Robots', 'idxboost-seo' ), __( 'SEO: Sitemap & Robots', 'idxboost-seo' ), 'manage_options', 'idxb-seo-sitemap', array( __CLASS__, 'render_off' ) );
	}

	public static function render_off() {
		$conf = IDXB_SEO_Conflicts::detect_plugins();
		echo '<div class="wrap"><h1>' . esc_html__( 'SEO: Sitemap & Robots', 'idxboost-seo' ) . '</h1>';
		if ( isset( $_GET['idxb_module'] ) && 'off' === $_GET['idxb_module'] ) { // phpcs:ignore WordPress.Security.NonceVerification
			echo '<div class="notice notice-success"><p>' . esc_html__( 'Module turned off. robots.txt was left exactly as published.', 'idxboost-seo' ) . '</p></div>';
		}
		echo '<div class="card" style="max-width:720px"><h2>' . esc_html__( 'Module is off', 'idxboost-seo' ) . '</h2>';
		echo '<p>' . __( 'When turned on, IDXBoost generates the site XML sitemaps (<code>/sitemap_index.xml</code>, including property detail pages) and manages <code>robots.txt</code>:', 'idxboost-seo' ) . '</p><ul style="list-style:disc;padding-left:20px">';
		echo '<li>' . esc_html__( 'It reads the robots.txt the site already has and loads it into the editor; nothing different is published until you save.', 'idxboost-seo' ) . '</li>';
		echo '<li>' . esc_html__( 'If the site has its own robots.txt file it is respected: it is not modified until you click “Publish to the site robots.txt”, and a copy of the original is saved first. It is never deleted, not even when turning the module off.', 'idxboost-seo' ) . '</li>';
		echo '<li>' . esc_html__( 'It replaces the WordPress, Yoast SEO and Rank Math sitemaps (their noindex/canonical settings are still respected).', 'idxboost-seo' ) . '</li></ul>';
		if ( $conf ) {
			echo '<p><strong>' . esc_html__( 'SEO plugins detected:', 'idxboost-seo' ) . '</strong> ' . esc_html( implode( ', ', $conf ) ) . '.</p>';
		}
		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
		wp_nonce_field( 'idxb_seo_module' );
		echo '<input type="hidden" name="action" value="idxb_seo_module"><input type="hidden" name="enable" value="1">';
		submit_button( __( 'Turn on SEO module', 'idxboost-seo' ) );
		echo '</form></div></div>';
	}

	/** Tools-page form to switch the module off (module mode only). */
	public static function module_off_form(): string {
		if ( ! defined( 'IDXB_SEO_MODULE' ) ) {
			return '';
		}
		return '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" onsubmit="return confirm(\'' . esc_js( __( 'Turn off the SEO module? Sitemaps go back to WordPress or other plugins. robots.txt stays as it is.', 'idxboost-seo' ) ) . '\')">'
			. wp_nonce_field( 'idxb_seo_module', '_wpnonce', true, false )
			. '<input type="hidden" name="action" value="idxb_seo_module"><input type="hidden" name="enable" value="0">'
			. '<button class="button idxb-danger">' . esc_html__( 'Turn off SEO module', 'idxboost-seo' ) . '</button></form>';
	}

	public static function menu() {
		$cap = 'manage_options';
		if ( defined( 'IDXB_SEO_MODULE' ) ) {
			global $admin_page_hooks;
			$parent = isset( $admin_page_hooks['flex-idx'] ) ? 'flex-idx' : 'options-general.php';
			add_submenu_page( $parent, 'IDXBoost Sitemap', __( 'SEO: Sitemap & Robots', 'idxboost-seo' ), $cap, 'idxb-seo-sitemap', array( __CLASS__, 'render' ) );
			// Reached through the tabs inside the screen, not listed in the menu.
			add_submenu_page( 'options.php', 'IDXBoost Robots', 'Robots', $cap, 'idxb-seo-robots', array( __CLASS__, 'render' ) );
			add_submenu_page( 'options.php', __( 'IDXBoost SEO — Tools', 'idxboost-seo' ), __( 'Tools', 'idxboost-seo' ), $cap, 'idxb-seo-tools', array( __CLASS__, 'render' ) );
			return;
		}
		add_menu_page( 'IDXBoost SEO', 'IDXBoost SEO', $cap, 'idxb-seo-sitemap', array( __CLASS__, 'render' ), 'dashicons-networking', 81 );
		add_submenu_page( 'idxb-seo-sitemap', 'IDXBoost Sitemap', 'Sitemap', $cap, 'idxb-seo-sitemap', array( __CLASS__, 'render' ) );
		add_submenu_page( 'idxb-seo-sitemap', 'IDXBoost Robots', 'Robots', $cap, 'idxb-seo-robots', array( __CLASS__, 'render' ) );
		add_submenu_page( 'idxb-seo-sitemap', __( 'IDXBoost SEO — Tools', 'idxboost-seo' ), __( 'Tools', 'idxboost-seo' ), $cap, 'idxb-seo-tools', array( __CLASS__, 'render' ) );
	}

	public static function action_links( $links ) {
		array_unshift( $links, '<a href="' . esc_url( admin_url( 'admin.php?page=idxb-seo-sitemap' ) ) . '">' . esc_html__( 'Settings', 'idxboost-seo' ) . '</a>' );
		return $links;
	}

	private static function current_route(): string {
		$page = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
		return self::PAGES[ $page ] ?? '';
	}

	public static function assets( $hook ) {
		$route = self::current_route();
		if ( ! $route ) {
			return;
		}
		$ver = IDXB_SEO_VERSION . '.' . filemtime( IDXB_SEO_DIR . 'admin/admin.js' );
		wp_enqueue_style( 'idxb-seo-admin', IDXB_SEO_URL . 'admin/admin.css', array(), $ver );
		wp_enqueue_script( 'idxb-seo-admin', IDXB_SEO_URL . 'admin/admin.js', array(), $ver, true );
		$boot = IDXB_SEO_REST::get_settings();
		wp_localize_script(
			'idxb-seo-admin',
			'IDXB_SEO',
			array(
				'route'    => $route,
				'rest'     => esc_url_raw( rest_url( IDXB_SEO_REST::NS ) ),
				'nonce'    => wp_create_nonce( 'wp_rest' ),
				'urls'     => array(
					'sitemap' => admin_url( 'admin.php?page=idxb-seo-sitemap' ),
					'robots'  => admin_url( 'admin.php?page=idxb-seo-robots' ),
					'tools'   => admin_url( 'admin.php?page=idxb-seo-tools' ),
					'reading' => admin_url( 'options-reading.php' ),
				),
				'boot'     => $boot,
				'version'  => IDXB_SEO_VERSION,
				'moduleOff'=> self::module_off_form(),
			)
		);
	}

	public static function render() {
		echo '<div class="wrap idxb-seo"><div id="idxb-seo-app"><p>Cargando…</p></div></div>';
	}

	/* ---------- per-post "exclude from sitemap" ---------- */

	public static function metabox() {
		foreach ( array_keys( IDXB_SEO_Sitemap_Builder::available_post_types() ) as $pt ) {
			add_meta_box( 'idxb-seo-exclude', 'IDXBoost SEO', array( __CLASS__, 'metabox_html' ), $pt, 'side', 'low' );
		}
	}

	public static function metabox_html( $post ) {
		wp_nonce_field( 'idxb_seo_exclude', 'idxb_seo_exclude_nonce' );
		$v = get_post_meta( $post->ID, '_idxb_seo_exclude', true );
		echo '<label><input type="checkbox" name="idxb_seo_exclude" value="1" ' . checked( '1', $v, false ) . '> ' . esc_html__( 'Exclude from XML sitemaps', 'idxboost-seo' ) . '</label>';
	}

	public static function save_metabox( $post_id ) {
		if ( ! isset( $_POST['idxb_seo_exclude_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['idxb_seo_exclude_nonce'] ), 'idxb_seo_exclude' ) ) {
			return;
		}
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		if ( ! empty( $_POST['idxb_seo_exclude'] ) ) {
			update_post_meta( $post_id, '_idxb_seo_exclude', '1' );
		} else {
			delete_post_meta( $post_id, '_idxb_seo_exclude' );
		}
	}
}
