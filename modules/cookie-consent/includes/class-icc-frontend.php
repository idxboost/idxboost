<?php
/**
 * Front-end output: inline CSS/JS, banner markup and script blocking.
 *
 * Everything is inlined and identical for every visitor, so full-page caches
 * (Cloudflare, LiteSpeed, WP Rocket…) can serve it; consent is resolved in the browser.
 *
 * @package IDX_Cookie_Consent
 */

defined( 'ABSPATH' ) || exit;

/**
 * Front-end controller.
 */
class ICC_Frontend {

	/**
	 * Options.
	 *
	 * @var array
	 */
	private $o;

	/**
	 * Handle => category map for enqueued scripts to block.
	 *
	 * @var array
	 */
	private $handles = array();

	/**
	 * Hook in once the main query is known.
	 */
	public function __construct() {
		add_action( 'wp', array( $this, 'boot' ) );
	}

	/**
	 * Register output hooks when the banner should run on this request.
	 */
	public function boot() {
		$this->o = ICC_Options::get();
		if ( ! $this->should_run() ) {
			return;
		}
		add_action( 'wp_head', array( $this, 'head' ), 1 );
		add_action( 'wp_footer', array( $this, 'footer' ), 1000 );

		if ( ! empty( $this->o['idxb_compat'] ) && class_exists( 'ICC_IDXBoost' ) && ICC_IDXBoost::detected() ) {
			new ICC_IDXBoost( $this->o );
		}

		$this->handles = ICC_Options::parse_handles( $this->o['handles'] );
		if ( $this->handles ) {
			add_filter( 'script_loader_tag', array( $this, 'block_handle' ), 999, 2 );
		}
	}

	/**
	 * Whether to output on this request.
	 *
	 * @return bool
	 */
	private function should_run() {
		$run = ! empty( $this->o['enabled'] )
			&& ! is_admin()
			&& ! wp_doing_ajax()
			&& ! is_feed()
			&& ! is_embed()
			&& ! ( defined( 'REST_REQUEST' ) && REST_REQUEST )
			&& ! ( function_exists( 'amp_is_request' ) && amp_is_request() );
		return (bool) apply_filters( 'icc_should_run', $run );
	}

	/**
	 * Enabled categories.
	 *
	 * @return array
	 */
	private function enabled_cats() {
		$cats = array();
		foreach ( ICC_Options::CATS as $c ) {
			if ( ! empty( $this->o['cats'][ $c ]['enabled'] ) ) {
				$cats[] = $c;
			}
		}
		return $cats;
	}

	/**
	 * Read a built asset once per request.
	 *
	 * @param string $file File name in assets/build.
	 * @return string
	 */
	private static function asset( $file ) {
		$path = ICC_DIR . 'assets/build/' . $file;
		return is_readable( $path ) ? trim( (string) file_get_contents( $path ) ) : ''; // phpcs:ignore WordPress.WP.AlternativeFunctions
	}

	/**
	 * Config consumed by boot.js / main.js.
	 *
	 * @return array
	 */
	private function config() {
		$o   = $this->o;
		$cfg = array(
			'ck'     => $o['cookie_name'],
			'rev'    => (int) $o['revision'],
			'days'   => (int) $o['cookie_days'],
			'dom'    => $o['cookie_domain'],
			'cats'   => $this->enabled_cats(),
			'reload' => (bool) $o['reload_on_revoke'],
			'gpc'    => (bool) $o['gpc'],
			'gcm'    => $o['gcm'] ? array(
				'red'  => (bool) $o['gcm_redaction'],
				'pass' => (bool) $o['gcm_passthrough'],
			) : false,
			'geo'    => false,
			'zz'     => false,
			'del'    => array(),
		);

		foreach ( ICC_Options::CATS as $c ) {
			$list = ICC_Options::to_list( $o['cats'][ $c ]['delete'] );
			if ( $list ) {
				$cfg['del'][ $c ] = $list;
			}
		}
		if ( ! $cfg['del'] ) {
			$cfg['del'] = new stdClass();
		}

		if ( $o['zaraz'] ) {
			$zz = array();
			foreach ( ICC_Options::CATS as $c ) {
				if ( '' !== $o['cats'][ $c ]['zaraz'] ) {
					$zz[ $c ] = $o['cats'][ $c ]['zaraz'];
				}
			}
			$cfg['zz'] = $zz ? $zz : false;
		}

		if ( $o['geo'] ) {
			$cfg['geo'] = array(
				'ck'   => $o['geo_cookie'],
				'list' => ICC_Options::to_list( $o['geo_countries'] ),
				'unk'  => $o['geo_unknown'],
				'tz'   => apply_filters( 'icc_geo_timezones', array( 'America/Los_Angeles' => 'US-CA' ) ),
				'tzf'  => (bool) $o['geo_tz'],
				'api'  => self::geo_api_url(),
				'm'    => 'POST',
				'ms'   => (int) apply_filters( 'icc_geo_api_timeout', 1500 ),
				'eur'  => (bool) $o['geo_europe'],
				'eu'   => $o['geo_europe'] || array_intersect( ICC_Options::to_list( $o['geo_countries'] ), explode( ',', ICC_Options::EU_COUNTRIES ) ),
			);
		}

		return apply_filters( 'icc_config', $cfg, $o );
	}

	/**
	 * <head>: CSS vars + CSS, config + boot script (Consent Mode defaults), category templates.
	 */
	public function head() {
		$o    = $this->o;
		$vars = sprintf(
			':root{--icc-bg:%s;--icc-fg:%s;--icc-btn:%s;--icc-btn-fg:%s;--icc-link:%s;--icc-r:%dpx}',
			$o['color_bg'],
			$o['color_text'],
			$o['color_btn'],
			$o['color_btn_text'],
			$o['color_link'],
			(int) $o['radius']
		);
		$json = wp_json_encode( $this->config(), JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_SLASHES );

		echo "\n<!-- IDX Cookie Consent -->\n";
		echo '<style id="icc-css">' . $vars . self::asset( 'style.min.css' ) . "</style>\n"; // phpcs:ignore WordPress.Security.EscapeOutput
		if ( $o['geo'] && self::geo_api_url() ) {
			// Warm up the connection for first-time visitors (the API is skipped once the location cookie exists).
			$api = wp_parse_url( self::geo_api_url() );
			if ( ! empty( $api['host'] ) ) {
				echo '<link rel="preconnect" href="' . esc_url( 'https://' . $api['host'] ) . '" crossorigin>' . "\n";
			}
		}
		echo '<script id="icc-boot">window.ICC_CFG=' . $json . ';' . self::asset( 'boot.min.js' ) . "</script>\n"; // phpcs:ignore WordPress.Security.EscapeOutput

		if ( '' !== trim( $o['necessary_head'] ) ) {
			echo $o['necessary_head'] . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput -- admin-provided code.
		}
		$this->templates( 'head' );
	}

	/**
	 * Print blocked code for each enabled category as inert <template>s.
	 *
	 * @param string $where head|body.
	 */
	private function templates( $where ) {
		foreach ( $this->enabled_cats() as $c ) {
			$code = $this->o['cats'][ $c ][ $where ];
			if ( '' !== trim( $code ) ) {
				echo '<template data-icc="' . esc_attr( $c ) . '">' . $code . "</template>\n"; // phpcs:ignore WordPress.Security.EscapeOutput -- admin-provided code.
			}
		}
	}

	/**
	 * Footer: body code, banner, preferences template, floating button, main script.
	 */
	public function footer() {
		$o = $this->o;

		if ( '' !== trim( $o['necessary_body'] ) ) {
			echo $o['necessary_body'] . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput -- admin-provided code.
		}
		$this->templates( 'body' );

		$policy = $o['policy_url'] ? $o['policy_url'] : get_privacy_policy_url();
		$class  = 'bar' === $o['layout'] ? '' : ( 'box-right' === $o['layout'] ? ' class="icc-box icc-box-r"' : ' class="icc-box"' );
		?>
<div id="icc-banner"<?php echo $class; // phpcs:ignore WordPress.Security.EscapeOutput ?> role="region" aria-label="<?php echo esc_attr( $o['prefs_title'] ); ?>">
	<div class="icc-in">
		<div class="icc-msg"><?php echo wp_kses_post( $o['message'] ); ?><?php if ( $policy ) : ?> <a class="icc-l" href="<?php echo esc_url( $policy ); ?>"><?php echo esc_html( $o['policy_text'] ); ?></a><?php endif; ?></div>
		<div class="icc-btns">
			<button type="button" class="icc-b icc-b2" data-icc-act="prefs"><?php echo esc_html( $o['btn_settings'] ); ?></button>
			<?php if ( ! empty( $o['reject_in_banner'] ) ) : ?><button type="button" class="icc-b" data-icc-act="reject"><?php echo esc_html( $o['btn_reject'] ); ?></button><?php endif; ?>
			<button type="button" class="icc-b" data-icc-act="accept"><?php echo esc_html( $o['btn_accept'] ); ?></button>
		</div>
	</div>
</div>
<template id="icc-tpl">
	<div id="icc-prefs">
		<div class="icc-dlg" role="dialog" aria-modal="true" aria-labelledby="icc-t">
			<button type="button" class="icc-x" data-icc-act="close" aria-label="Close">&times;</button>
			<div id="icc-t" class="icc-h"><?php echo esc_html( $o['prefs_title'] ); ?></div>
			<?php if ( $o['prefs_intro'] ) : ?><p><?php echo wp_kses_post( $o['prefs_intro'] ); ?></p><?php endif; ?>
			<?php $this->gpc_notice(); ?>
			<div class="icc-cat">
				<div class="icc-cat-h"><span><?php echo esc_html( $o['necessary_label'] ); ?></span><span class="icc-on"><?php echo esc_html( $o['always_active'] ); ?></span></div>
				<p><?php echo wp_kses_post( $o['necessary_desc'] ); ?></p>
			</div>
			<?php foreach ( $this->enabled_cats() as $c ) : $cat = $o['cats'][ $c ]; ?>
			<div class="icc-cat">
				<div class="icc-cat-h"><label for="icc-c-<?php echo esc_attr( $c ); ?>"><?php echo esc_html( $cat['label'] ); ?></label><span class="icc-sw"><input type="checkbox" id="icc-c-<?php echo esc_attr( $c ); ?>" data-cat="<?php echo esc_attr( $c ); ?>"><span></span></span></div>
				<?php if ( $cat['desc'] ) : ?><p><?php echo wp_kses_post( $cat['desc'] ); ?></p><?php endif; ?>
			</div>
			<?php endforeach; ?>
			<div class="icc-btns">
				<button type="button" class="icc-b icc-b2" data-icc-act="reject"><?php echo esc_html( $o['btn_reject'] ); ?></button>
				<button type="button" class="icc-b icc-b2" data-icc-act="save"><?php echo esc_html( $o['btn_save'] ); ?></button>
				<button type="button" class="icc-b" data-icc-act="accept"><?php echo esc_html( $o['btn_accept'] ); ?></button>
			</div>
		</div>
	</div>
</template>
		<?php if ( $o['fab'] ) : ?>
<button type="button" id="icc-fab"<?php echo 'right' === $o['fab_position'] ? ' class="icc-fab-r"' : ''; ?> data-icc-open aria-label="<?php echo esc_attr( $o['fab_label'] ); ?>" title="<?php echo esc_attr( $o['fab_label'] ); ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5zM8.5 8a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3zm-1 5.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3zm6 1a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3zm-1.5-4a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg></button>
		<?php endif; ?>
<noscript><style>#icc-banner{display:none}</style></noscript>
<script id="icc-main"><?php echo self::asset( 'main.min.js' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></script>
<!-- /IDX Cookie Consent -->
		<?php
	}

	/**
	 * Location service (internal): the IDXBoost geo endpoint, queried with POST on a visitor's first page view.
	 *
	 * @return string
	 */
	private static function geo_api_url() {
		$url = defined( 'IDX_BOOST_GET_COUNTRY_LEAD' ) ? IDX_BOOST_GET_COUNTRY_LEAD : 'https://api.idxboost.com/get/ip_lead';
		return (string) apply_filters( 'icc_geo_api_url', $url );
	}

	/**
	 * GPC confirmation (shown via CSS only when the browser sends the signal).
	 */
	private function gpc_notice() {
		if ( $this->o['gpc'] && $this->o['gpc_text'] ) {
			echo '<p class="icc-gpc" role="status">' . wp_kses_post( $this->o['gpc_text'] ) . '</p>';
		}
	}

	/**
	 * Neutralise <script> tags of mapped handles until consent is given.
	 *
	 * @param string $tag    Full tag HTML (includes before/after inline scripts).
	 * @param string $handle Script handle.
	 * @return string
	 */
	public function block_handle( $tag, $handle ) {
		if ( ! isset( $this->handles[ $handle ] ) ) {
			return $tag;
		}
		return self::block_html( $tag, $this->handles[ $handle ] );
	}

	/**
	 * Turn every executable <script> in $html into an inert text/plain one tagged with a category.
	 *
	 * @param string $html     HTML.
	 * @param string $category Category key.
	 * @return string
	 */
	public static function block_html( $html, $category ) {
		return preg_replace_callback(
			'/<script\b([^>]*)>/i',
			static function ( $m ) use ( $category ) {
				$attrs = $m[1];
				$type  = '';
				if ( preg_match( '/\stype\s*=\s*(["\']?)([^"\'\s>]*)\1/i', $attrs, $t ) ) {
					$type = strtolower( $t[2] );
					if ( '' !== $type && ! in_array( $type, array( 'text/javascript', 'application/javascript', 'module' ), true ) ) {
						return $m[0]; // JSON, templates, etc. are not executable.
					}
					$attrs = str_replace( $t[0], '', $attrs );
				}
				$extra = 'module' === $type ? ' data-icc-type="module"' : '';
				$attrs = trim( $attrs );
				return '<script type="text/plain" data-icc="' . esc_attr( $category ) . '"' . $extra . ( '' !== $attrs ? ' ' . $attrs : '' ) . '>';
			},
			$html
		);
	}

	/**
	 * [icc_settings text="Cookie settings"] → link that reopens the preferences.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function shortcode( $atts ) {
		$o    = ICC_Options::get();
		$atts = shortcode_atts( array( 'text' => $o['fab_label'] ), $atts, 'icc_settings' );
		return '<a href="#icc-settings" class="icc-open" data-icc-open>' . esc_html( $atts['text'] ) . '</a>';
	}

	/**
	 * [icc_do_not_sell] → CCPA "Do Not Sell or Share" link: opens preferences with marketing turned off.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function shortcode_dns( $atts ) {
		$o    = ICC_Options::get();
		$atts = shortcode_atts( array( 'text' => $o['dns_text'] ), $atts, 'icc_do_not_sell' );
		return '<a href="#icc-do-not-sell" class="icc-dns" data-icc-act="optout">' . esc_html( $atts['text'] ) . '</a>';
	}
}
