<?php
/**
 * Settings page (Settings → Cookie Consent).
 *
 * @package IDX_Cookie_Consent
 */

defined( 'ABSPATH' ) || exit;

/**
 * Admin controller.
 */
class ICC_Admin {

	const SLUG = 'idx-cookie-consent';

	/**
	 * Current options while rendering.
	 *
	 * @var array
	 */
	private $o = array();

	/**
	 * Screen hook suffix of the settings page.
	 *
	 * @var string
	 */
	private $hook = '';

	/**
	 * Hooks.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'menu' ), 20 ); // after IDXBoost builds its menu.
		add_action( 'admin_init', array( $this, 'register' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
		add_action( 'update_option_' . ICC_Options::KEY, array( __CLASS__, 'purge_caches' ) );
		if ( ! defined( 'ICC_MODULE' ) ) {
			add_filter( 'plugin_action_links_' . plugin_basename( ICC_FILE ), array( $this, 'action_link' ) );
		}
	}

	/**
	 * Menu entry.
	 */
	public function menu() {
		global $admin_page_hooks;
		$title = __( 'Cookie Consent', 'idx-cookie-consent' );
		// Inside the "IDX Boost" admin menu when it exists, otherwise under Settings.
		if ( isset( $admin_page_hooks['flex-idx'] ) ) {
			$this->hook = (string) add_submenu_page( 'flex-idx', $title, $title, 'manage_options', self::SLUG, array( $this, 'page' ) );
		} else {
			$this->hook = (string) add_options_page( $title, $title, 'manage_options', self::SLUG, array( $this, 'page' ) );
		}
	}

	/**
	 * Register the option.
	 */
	public function register() {
		register_setting(
			'icc',
			ICC_Options::KEY,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( 'ICC_Options', 'sanitize' ),
				'default'           => ICC_Options::defaults(),
			)
		);
	}

	/**
	 * Settings link on the plugins screen.
	 *
	 * @param array $links Links.
	 * @return array
	 */
	public function action_link( $links ) {
		array_unshift( $links, '<a href="' . esc_url( admin_url( 'admin.php?page=' . self::SLUG ) ) . '">' . esc_html__( 'Settings', 'idx-cookie-consent' ) . '</a>' );
		return $links;
	}

	/**
	 * Admin assets (only on our page): core color picker + code editor.
	 *
	 * @param string $hook Current screen hook.
	 */
	public function assets( $hook ) {
		if ( ! $this->hook || $this->hook !== $hook ) {
			return;
		}
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		$editor = wp_enqueue_code_editor( array( 'type' => 'text/html' ) );

		wp_add_inline_style(
			'wp-color-picker',
			'.icc-tabs{margin:16px 0 0}.icc-panel{display:none;background:#fff;border:1px solid #c3c4c7;border-top:0;padding:8px 20px 16px}.icc-panel.on{display:block}
			.icc-panel textarea.large-text{min-height:90px}.icc-panel .CodeMirror{height:160px;border:1px solid #dcdcde}.icc-cat-box{border:1px solid #dcdcde;padding:4px 16px 8px;margin:16px 0;border-radius:4px}
			.icc-note{background:#f0f6fc;border-left:4px solid #72aee6;padding:10px 14px;margin:12px 0}.icc-note code{font-size:12px}.icc-adv{margin:24px 0 8px;border:1px solid #dcdcde;border-radius:4px;padding:8px 16px;background:#f6f7f7}.icc-adv summary{cursor:pointer;font-weight:600;font-size:14px}'
		);
		wp_add_inline_script(
			'wp-color-picker',
			'jQuery(function($){
				$(".icc-color").wpColorPicker();
				var cm=' . wp_json_encode( $editor ? $editor : false ) . ',eds=[];
				function show(id){$(".icc-tabs a").removeClass("nav-tab-active").filter("[href=\"#"+id+"\"]").addClass("nav-tab-active");$(".icc-panel").removeClass("on");$("#"+id).addClass("on");eds.forEach(function(e){e.codemirror.refresh()});try{sessionStorage.setItem("icc_tab",id)}catch(e){}}
				$(".icc-tabs a").on("click",function(e){e.preventDefault();show(this.hash.slice(1))});
				if(cm&&window.wp&&wp.codeEditor){$(".icc-code").each(function(){eds.push(wp.codeEditor.initialize(this,cm))})}
				var t=null;try{t=sessionStorage.getItem("icc_tab")}catch(e){}show(t&&$("#"+t).length?t:"icc-general");
			});'
		);
	}

	/* ---------- Field helpers ---------- */

	/**
	 * Field name attribute.
	 *
	 * @param string $key  Key.
	 * @param string $sub  Optional category.
	 * @return string
	 */
	private function name( $key, $sub = '' ) {
		return $sub ? ICC_Options::KEY . '[cats][' . $sub . '][' . $key . ']' : ICC_Options::KEY . '[' . $key . ']';
	}

	/**
	 * Value.
	 *
	 * @param string $key Key.
	 * @param string $sub Optional category.
	 * @return mixed
	 */
	private function val( $key, $sub = '' ) {
		return $sub ? $this->o['cats'][ $sub ][ $key ] : $this->o[ $key ];
	}

	/**
	 * Table row wrapper.
	 *
	 * @param string $label Label.
	 * @param string $html  Control HTML.
	 * @param string $help  Help text.
	 */
	private function row( $label, $html, $help = '' ) {
		echo '<tr><th scope="row">' . esc_html( $label ) . '</th><td>' . $html; // phpcs:ignore WordPress.Security.EscapeOutput -- built from escaped parts.
		if ( $help ) {
			echo '<p class="description">' . wp_kses_post( $help ) . '</p>';
		}
		echo '</td></tr>';
	}

	private function text( $label, $key, $sub = '', $help = '', $class = 'regular-text' ) {
		$this->row( $label, sprintf( '<input type="text" class="%s" name="%s" value="%s">', esc_attr( $class ), esc_attr( $this->name( $key, $sub ) ), esc_attr( $this->val( $key, $sub ) ) ), $help );
	}

	private function number( $label, $key, $min, $max, $help = '' ) {
		$this->row( $label, sprintf( '<input type="number" class="small-text" min="%d" max="%d" name="%s" value="%d">', $min, $max, esc_attr( $this->name( $key ) ), (int) $this->val( $key ) ), $help );
	}

	private function textarea( $label, $key, $sub = '', $help = '', $code = false ) {
		$this->row( $label, sprintf( '<textarea class="large-text%s" rows="4" name="%s"%s>%s</textarea>', $code ? ' icc-code code' : '', esc_attr( $this->name( $key, $sub ) ), $code ? ' spellcheck="false"' : '', esc_textarea( $this->val( $key, $sub ) ) ), $help );
	}

	private function check( $label, $key, $sub = '', $text = '', $help = '' ) {
		$this->row( $label, sprintf( '<label><input type="checkbox" name="%s" value="1"%s> %s</label>', esc_attr( $this->name( $key, $sub ) ), checked( 1, (int) $this->val( $key, $sub ), false ), esc_html( $text ) ), $help );
	}

	private function select( $label, $key, $choices, $help = '' ) {
		$opts = '';
		foreach ( $choices as $v => $t ) {
			$opts .= sprintf( '<option value="%s"%s>%s</option>', esc_attr( $v ), selected( $this->val( $key ), $v, false ), esc_html( $t ) );
		}
		$this->row( $label, '<select name="' . esc_attr( $this->name( $key ) ) . '">' . $opts . '</select>', $help );
	}

	private function color( $label, $key ) {
		$this->row( $label, sprintf( '<input type="text" class="icc-color" name="%s" value="%s">', esc_attr( $this->name( $key ) ), esc_attr( $this->val( $key ) ) ) );
	}

	/* ---------- Page ---------- */

	/**
	 * Render the settings page. Tabs: Banner (look & texts), Scripts (what is blocked), Settings (where and how).
	 */
	public function page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$this->o = ICC_Options::get();
		$tabs    = array(
			'icc-general'    => __( 'Banner', 'idx-cookie-consent' ),
			'icc-categories' => __( 'Scripts', 'idx-cookie-consent' ),
			'icc-settings'   => __( 'Settings', 'idx-cookie-consent' ),
		);
		$can_code = current_user_can( 'unfiltered_html' );
		?>
<div class="wrap">
	<h1><?php esc_html_e( 'Cookie Consent', 'idx-cookie-consent' ); ?></h1>
	<p><?php esc_html_e( 'After saving, purge your page cache (and Cloudflare cache if HTML is cached there) so visitors get the new settings.', 'idx-cookie-consent' ); ?></p>
	<nav class="nav-tab-wrapper icc-tabs">
		<?php foreach ( $tabs as $id => $t ) : ?>
			<a href="#<?php echo esc_attr( $id ); ?>" class="nav-tab"><?php echo esc_html( $t ); ?></a>
		<?php endforeach; ?>
	</nav>
	<form method="post" action="options.php">
		<?php settings_fields( 'icc' ); ?>

		<div id="icc-general" class="icc-panel on">
			<table class="form-table" role="presentation">
				<?php
				$this->check( __( 'Status', 'idx-cookie-consent' ), 'enabled', '', __( 'Show the cookie banner', 'idx-cookie-consent' ) );
				$this->select(
					__( 'Layout', 'idx-cookie-consent' ),
					'layout',
					array(
						'bar'       => __( 'Full-width bar (bottom)', 'idx-cookie-consent' ),
						'box-left'  => __( 'Box (bottom left)', 'idx-cookie-consent' ),
						'box-right' => __( 'Box (bottom right)', 'idx-cookie-consent' ),
					)
				);
				$this->textarea( __( 'Message', 'idx-cookie-consent' ), 'message', '', __( 'Basic HTML allowed.', 'idx-cookie-consent' ) );
				$this->text( __( 'Policy link text', 'idx-cookie-consent' ), 'policy_text' );
				$this->text( __( 'Policy URL', 'idx-cookie-consent' ), 'policy_url', '', __( 'Empty = WordPress privacy policy page (Settings → Privacy).', 'idx-cookie-consent' ), 'large-text' );
				$this->text( __( '"Accept" button', 'idx-cookie-consent' ), 'btn_accept' );
				$this->text( __( '"Preferences" button', 'idx-cookie-consent' ), 'btn_settings' );
				$this->text( __( '"Reject" button', 'idx-cookie-consent' ), 'btn_reject', '', __( 'Always available inside Preferences.', 'idx-cookie-consent' ) );
				$this->check( '', 'reject_in_banner', '', __( 'Also show "Reject" directly in the banner', 'idx-cookie-consent' ) );
				$this->text( __( '"Save" button', 'idx-cookie-consent' ), 'btn_save' );
				$this->text( __( 'Preferences title', 'idx-cookie-consent' ), 'prefs_title' );
				$this->textarea( __( 'Preferences intro', 'idx-cookie-consent' ), 'prefs_intro' );
				$this->text( __( 'Necessary: label', 'idx-cookie-consent' ), 'necessary_label' );
				$this->textarea( __( 'Necessary: description', 'idx-cookie-consent' ), 'necessary_desc' );
				$this->text( __( '"Always active" text', 'idx-cookie-consent' ), 'always_active' );
				$this->color( __( 'Background', 'idx-cookie-consent' ), 'color_bg' );
				$this->color( __( 'Text', 'idx-cookie-consent' ), 'color_text' );
				$this->color( __( 'Button', 'idx-cookie-consent' ), 'color_btn' );
				$this->color( __( 'Button text', 'idx-cookie-consent' ), 'color_btn_text' );
				$this->color( __( 'Links / accents', 'idx-cookie-consent' ), 'color_link' );
				$this->number( __( 'Corner radius (px)', 'idx-cookie-consent' ), 'radius', 0, 30 );
				$this->check( __( 'Floating button', 'idx-cookie-consent' ), 'fab', '', __( 'Show a small button to reopen preferences after a choice', 'idx-cookie-consent' ), __( 'You can also use the shortcode <code>[icc_settings text="Cookie settings"]</code> or any link to <code>#icc-settings</code>.', 'idx-cookie-consent' ) );
				$this->select(
					__( 'Floating button position', 'idx-cookie-consent' ),
					'fab_position',
					array(
						'left'  => __( 'Bottom left', 'idx-cookie-consent' ),
						'right' => __( 'Bottom right', 'idx-cookie-consent' ),
					)
				);
				$this->text( __( 'Floating button label', 'idx-cookie-consent' ), 'fab_label' );
				?>
			</table>
		</div>

		<div id="icc-categories" class="icc-panel">
			<?php if ( ! $can_code ) : ?>
				<div class="notice notice-warning inline"><p><?php esc_html_e( 'Your account cannot save unfiltered HTML, so script fields are read-only and keep their current value.', 'idx-cookie-consent' ); ?></p></div>
			<?php endif; ?>
			<div class="icc-note">
				<?php echo wp_kses_post( __( 'Paste each tracking snippet (GA4, GTM, Meta Pixel, Clarity…) in its category. It is printed inert and only runs after the visitor allows that category — no extra requests before consent. Snippets that use <code>document.write</code> are not supported.', 'idx-cookie-consent' ) ); ?>
			</div>
			<?php $this->idxboost_section(); ?>
			<div class="icc-cat-box">
				<h2><?php esc_html_e( 'Strictly necessary (always runs)', 'idx-cookie-consent' ); ?></h2>
				<table class="form-table" role="presentation">
					<?php
					$this->textarea( __( 'Code in <head>', 'idx-cookie-consent' ), 'necessary_head', '', '', true );
					$this->textarea( __( 'Code before </body>', 'idx-cookie-consent' ), 'necessary_body', '', '', true );
					?>
				</table>
			</div>
			<?php foreach ( ICC_Options::CATS as $c ) : ?>
			<div class="icc-cat-box">
				<h2><?php echo esc_html( $this->o['cats'][ $c ]['label'] ); ?> <code><?php echo esc_html( $c ); ?></code></h2>
				<table class="form-table" role="presentation">
					<?php
					$this->check( __( 'Enabled', 'idx-cookie-consent' ), 'enabled', $c, __( 'Offer this category to visitors', 'idx-cookie-consent' ) );
					$this->text( __( 'Label', 'idx-cookie-consent' ), 'label', $c );
					$this->textarea( __( 'Description', 'idx-cookie-consent' ), 'desc', $c );
					$this->textarea( __( 'Code in <head>', 'idx-cookie-consent' ), 'head', $c, '', true );
					$this->textarea( __( 'Code before </body>', 'idx-cookie-consent' ), 'body', $c, '', true );
					$this->textarea( __( 'Cookies to delete on withdrawal', 'idx-cookie-consent' ), 'delete', $c, __( 'One name or prefix per line (e.g. <code>_ga</code> also removes <code>_ga_XXXX</code>).', 'idx-cookie-consent' ) );
					if ( $this->o['zaraz'] ) {
						$this->text( __( 'Zaraz purpose ID', 'idx-cookie-consent' ), 'zaraz', $c );
					} else {
						echo '<input type="hidden" name="' . esc_attr( $this->name( 'zaraz', $c ) ) . '" value="' . esc_attr( $this->val( 'zaraz', $c ) ) . '">';
					}
					?>
				</table>
			</div>
			<?php endforeach; ?>
			<table class="form-table" role="presentation">
				<?php $this->textarea( __( 'Block enqueued scripts', 'idx-cookie-consent' ), 'handles', '', __( 'For scripts added by the theme or other plugins with <code>wp_enqueue_script</code>. One <code>handle:category</code> per line, e.g. <code>google-analytics:analytics</code>. The script (and its inline code) stays inert until consent.', 'idx-cookie-consent' ) ); ?>
			</table>
		</div>

		<div id="icc-settings" class="icc-panel">
			<h2><?php esc_html_e( 'Where to show the banner', 'idx-cookie-consent' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php
				$this->check( __( 'Geolocation', 'idx-cookie-consent' ), 'geo', '', __( 'Only ask for consent in the regions below', 'idx-cookie-consent' ), __( 'Off = the banner is shown to every visitor. On = visitors from anywhere else get no banner and all enabled categories run.', 'idx-cookie-consent' ) );
				$this->check( __( 'All of Europe', 'idx-cookie-consent' ), 'geo_europe', '', __( 'Every visitor from Europe (continent = EU)', 'idx-cookie-consent' ) );
				$this->textarea( __( 'Countries / regions', 'idx-cookie-consent' ), 'geo_countries', '', __( 'ISO codes separated by commas: a country (<code>DE</code>, <code>BR</code>) or a state (<code>US-CA</code> = California). Default: EU/EEA + UK + Switzerland + California.', 'idx-cookie-consent' ) );
				?>
			</table>

			<h2><?php esc_html_e( 'United States (CCPA)', 'idx-cookie-consent' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php
				$this->check( __( 'Global Privacy Control', 'idx-cookie-consent' ), 'gpc', '', __( 'Honor the browser GPC signal (marketing off)', 'idx-cookie-consent' ), __( 'Required in California and several other states. The confirmation is shown inside Preferences.', 'idx-cookie-consent' ) );
				$this->textarea( __( 'GPC confirmation text', 'idx-cookie-consent' ), 'gpc_text' );
				$this->text( __( '"Do Not Sell or Share" link text', 'idx-cookie-consent' ), 'dns_text', '', __( 'Add it to the footer with <code>[icc_do_not_sell]</code> or any link to <code>#icc-do-not-sell</code>.', 'idx-cookie-consent' ), 'large-text' );
				?>
			</table>

			<h2><?php esc_html_e( 'Google', 'idx-cookie-consent' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php
				$this->check( __( 'Consent Mode v2', 'idx-cookie-consent' ), 'gcm', '', __( 'Send the visitor\'s choice to Google tags (GA4, Ads, GTM)', 'idx-cookie-consent' ) );
				$this->check( '', 'gcm_redaction', '', 'ads_data_redaction' );
				$this->check( '', 'gcm_passthrough', '', 'url_passthrough' );
				?>
			</table>

			<h2><?php esc_html_e( 'Consent', 'idx-cookie-consent' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php
				$this->number( __( 'Remember choice (days)', 'idx-cookie-consent' ), 'cookie_days', 1, 395, __( 'GDPR guidance: ask again after 6–12 months.', 'idx-cookie-consent' ) );
				$this->row(
					__( 'Ask everyone again', 'idx-cookie-consent' ),
					'<label><input type="checkbox" name="icc_bump_revision" value="1"> ' . esc_html__( 'On save, reset all stored choices (e.g. after changing your policy)', 'idx-cookie-consent' ) . '</label> <span class="description">(' . esc_html__( 'revision', 'idx-cookie-consent' ) . ' ' . (int) $this->o['revision'] . ')</span>'
				);
				?>
			</table>

			<details class="icc-adv">
				<summary><?php esc_html_e( 'Advanced', 'idx-cookie-consent' ); ?></summary>
				<table class="form-table" role="presentation">
					<?php
					$this->select(
						__( 'Location unknown', 'idx-cookie-consent' ),
						'geo_unknown',
						array(
							'tz'   => __( 'Guess from browser time zone', 'idx-cookie-consent' ),
							'show' => __( 'Show the banner', 'idx-cookie-consent' ),
							'hide' => __( 'Do not show the banner', 'idx-cookie-consent' ),
						),
						__( 'Used only if the location service does not answer.', 'idx-cookie-consent' )
					);
					$this->check( __( 'Time zone fallback', 'idx-cookie-consent' ), 'geo_tz', '', __( 'If only the country is known, treat US visitors on Pacific time as California', 'idx-cookie-consent' ) );
					$this->text( __( 'Location cookie name', 'idx-cookie-consent' ), 'geo_cookie', '', __( 'Optional: a Cloudflare rule/Worker can set it to skip the location service (see readme).', 'idx-cookie-consent' ) );
					$this->check( __( 'Cloudflare Zaraz', 'idx-cookie-consent' ), 'zaraz', '', __( 'Send the choice to the Zaraz Consent API', 'idx-cookie-consent' ), __( 'After saving, a "Zaraz purpose ID" field appears in each category (Scripts tab).', 'idx-cookie-consent' ) );
					$this->text( __( 'Consent cookie name', 'idx-cookie-consent' ), 'cookie_name' );
					$this->text( __( 'Cookie domain', 'idx-cookie-consent' ), 'cookie_domain', '', __( 'Empty = current host. <code>.example.com</code> shares consent across subdomains.', 'idx-cookie-consent' ) );
					$this->check( __( 'Reload on withdrawal', 'idx-cookie-consent' ), 'reload_on_revoke', '', __( 'Reload the page when a visitor turns off a category that was already running', 'idx-cookie-consent' ) );
					?>
				</table>
			</details>
		</div>

		<?php submit_button(); ?>
	</form>
</div>
		<?php
	}

	/**
	 * IDXBoost integration settings (only when the IDXBoost plugin is loaded).
	 */
	private function idxboost_section() {
		if ( ! ICC_IDXBoost::detected() ) {
			return;
		}
		$cats = array(
			'marketing'   => __( 'Marketing', 'idx-cookie-consent' ),
			'analytics'   => __( 'Analytics', 'idx-cookie-consent' ),
			'preferences' => __( 'Preferences', 'idx-cookie-consent' ),
			'necessary'   => __( 'Strictly necessary (always runs)', 'idx-cookie-consent' ),
		);
		$found = '';
		foreach ( ICC_IDXBoost::status() as $fn => $ok ) {
			$found .= '<li>' . ( $ok ? '&#10003; ' : '&#10007; ' ) . '<code>' . esc_html( $fn ) . '()</code>' . ( $ok ? '' : ' — ' . esc_html__( 'not found (IDXBoost may have renamed it; those scripts load as before)', 'idx-cookie-consent' ) ) . '</li>';
		}
		?>
		<div class="icc-cat-box">
			<h2><?php esc_html_e( 'IDXBoost trackers', 'idx-cookie-consent' ); ?></h2>
			<p><?php esc_html_e( 'Holds the trackers that the IDXBoost plugin prints from the agent settings until the visitor consents, without changing IDXBoost: Google Analytics → Analytics, Google Ads → Marketing, Facebook Pixel and Follow Up Boss → Marketing, StatCounter and Matomo → Analytics.', 'idx-cookie-consent' ); ?></p>
			<ul style="margin-left:1em"><?php echo wp_kses_post( $found ); ?></ul>
			<table class="form-table" role="presentation">
				<?php
				$this->check( __( 'IDXBoost integration', 'idx-cookie-consent' ), 'idxb_compat', '', __( 'Gate IDXBoost trackers by consent', 'idx-cookie-consent' ) );
				$this->select( __( 'IDXBoost CRM pixel + attribution (_ib_attr)', 'idx-cookie-consent' ), 'idxb_crm_cat', $cats, __( 'Lead tracking and UTM attribution. If it is not "Strictly necessary", visitors who reject will not be tracked or attributed.', 'idx-cookie-consent' ) );
				$this->select( __( 'Google Tag Manager', 'idx-cookie-consent' ), 'idxb_gtm_cat', $cats, __( 'Choose "Strictly necessary" only if every tag inside GTM respects Google Consent Mode.', 'idx-cookie-consent' ) );
				?>
			</table>
		</div>
		<?php
	}

	/**
	 * Best-effort page-cache purge for popular cache plugins after settings change.
	 */
	public static function purge_caches() {
		if ( function_exists( 'rocket_clean_domain' ) ) {
			rocket_clean_domain();
		}
		if ( function_exists( 'w3tc_flush_all' ) ) {
			w3tc_flush_all();
		}
		if ( function_exists( 'wp_cache_clear_cache' ) ) {
			wp_cache_clear_cache();
		}
		if ( function_exists( 'sg_cachepress_purge_cache' ) ) {
			sg_cachepress_purge_cache();
		}
		do_action( 'litespeed_purge_all' );
		do_action( 'breeze_clear_all_cache' );
		do_action( 'cloudflare_purge_everything' );
		do_action( 'icc_settings_saved' );
	}
}
