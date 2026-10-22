<?php
/**
 * IDXBoost compatibility: holds the trackers printed by the IDXBoost plugin
 * (GA/Ads, GTM, Facebook Pixel, Follow Up Boss, IDXBoost CRM pixel, StatCounter,
 * Matomo, _ib_attr) until the visitor consents — WITHOUT editing IDXBoost.
 *
 * Each IDXBoost output function is unhooked and re-hooked through a wrapper at
 * the same priority. The wrapper runs the original function untouched, captures
 * only its output and turns the recognised <script> tags into inert ones tagged
 * with a consent category. Anything not recognised is printed exactly as before.
 *
 * @package IDX_Cookie_Consent
 */

defined( 'ABSPATH' ) || exit;

/**
 * IDXBoost tracker gate.
 */
class ICC_IDXBoost {

	/**
	 * IDXBoost functions that print trackers: [ hook, function, priority ].
	 *
	 * @return array
	 */
	public static function targets() {
		return apply_filters(
			'icc_idxboost_targets',
			array(
				array( 'wp_head', 'idxboost_integrations_head', 0 ),       // FB pixel, FUB, CRM pixel, StatCounter, Matomo, _ib_attr.
				array( 'wp_head', 'iboost_print_analytics_script', 10 ),   // Google Analytics / Google Ads (gtag).
				array( 'idx_gtm_head', 'iboost_print_googlegtm_head_script', 0 ), // Google Tag Manager.
			)
		);
	}

	/**
	 * Whether the IDXBoost plugin is loaded.
	 *
	 * @return bool
	 */
	public static function detected() {
		return defined( 'FLEX_IDX_PATH' ) || function_exists( 'idxboost_integrations_head' );
	}

	/**
	 * Status of each target for the settings page.
	 *
	 * @return array function => bool (found)
	 */
	public static function status() {
		$out = array();
		foreach ( self::targets() as $t ) {
			$out[ $t[1] ] = function_exists( $t[1] );
		}
		return $out;
	}

	/**
	 * Options.
	 *
	 * @var array
	 */
	private $o;

	/**
	 * Swap the IDXBoost hooks for wrappers (front end only, called on `wp`).
	 *
	 * @param array $o Options.
	 */
	public function __construct( $o ) {
		$this->o = $o;
		foreach ( self::targets() as $t ) {
			list( $hook, $fn, $prio ) = $t;
			if ( function_exists( $fn ) && has_action( $hook, $fn ) === $prio ) {
				remove_action( $hook, $fn, $prio );
				add_action(
					$hook,
					function () use ( $fn ) {
						$this->run( $fn, func_get_args() );
					},
					$prio,
					10
				);
			}
		}
	}

	/**
	 * Run the original IDXBoost function and gate its scripts.
	 *
	 * @param string $fn   Function name.
	 * @param array  $args Hook arguments.
	 */
	private function run( $fn, $args ) {
		ob_start();
		try {
			call_user_func_array( $fn, $args );
		} finally {
			$html = ob_get_clean();
		}
		echo $this->gate( $html ); // phpcs:ignore WordPress.Security.EscapeOutput -- IDXBoost's own output, only script types are changed.
	}

	/**
	 * Category for a "configurable" IDXBoost item ('' = leave it running).
	 *
	 * @param string $key Option key.
	 * @return string
	 */
	private function cat( $key ) {
		$c = isset( $this->o[ $key ] ) ? $this->o[ $key ] : 'marketing';
		return in_array( $c, ICC_Options::CATS, true ) ? $c : '';
	}

	/**
	 * Tag each recognised <script> with its consent category.
	 *
	 * @param string $html Captured output.
	 * @return string
	 */
	public function gate( $html ) {
		if ( false === stripos( $html, '<script' ) ) {
			return $html;
		}
		// The GA/Ads block configures both IDs together: it counts as analytics when GA is present.
		$gtag_cat = preg_match( '/["\'](G-|UA-)[A-Z0-9-]+["\']/i', $html ) ? 'analytics' : 'marketing';

		return preg_replace_callback(
			'#<script\b[^>]*>.*?</script>#is',
			function ( $m ) use ( $gtag_cat ) {
				$tag = $m[0];
				$cat = $this->classify( $tag, $gtag_cat );
				return $cat ? ICC_Frontend::block_html( $tag, $cat ) : $tag;
			},
			$html
		);
	}

	/**
	 * Decide the category of one script tag ('' = not a tracker / leave as is).
	 *
	 * @param string $tag      Script tag.
	 * @param string $gtag_cat Category for gtag blocks.
	 * @return string
	 */
	private function classify( $tag, $gtag_cat ) {
		$rules = array(
			'gtm'       => '#googletagmanager\.com/gtm\.js|[\'"]GTM-[A-Z0-9]+[\'"]#i',
			'gtag'      => '#googletagmanager\.com/gtag/js|gtag\(\s*[\'"]config#i',
			'facebook'  => '#connect\.facebook\.net|fbq\(#i',
			'fub'       => '#WidgetTrackerObject#',
			'stat'      => '#statcounter\.com|sc_project#i',
			'matomo'    => '#_paq\b|matomo\.(js|php)#i',
			'attr'      => '#_ib_attr#',
			'crm_pixel' => '#getVisitorId|IDXBoost Pixel#i',
		);
		foreach ( $rules as $key => $re ) {
			if ( ! preg_match( $re, $tag ) ) {
				continue;
			}
			switch ( $key ) {
				case 'gtm':
					return $this->cat( 'idxb_gtm_cat' );
				case 'gtag':
					return $gtag_cat;
				case 'facebook':
				case 'fub':
					return 'marketing';
				case 'stat':
				case 'matomo':
					return 'analytics';
				default: // attr, crm_pixel.
					return $this->cat( 'idxb_crm_cat' );
			}
		}
		return '';
	}
}
