<?php
defined( 'ABSPATH' ) || exit;

/**
 * robots.txt: builder, linter, tester and delivery (virtual via filter or physical managed file).
 */
class IDXB_SEO_Robots {

	const MARKER        = '# Managed by IDXBoost SEO';
	const BLOCK_START   = '# START IDXBOOST BLOCK';
	const BLOCK_END     = '# END IDXBOOST BLOCK';
	const STATE_OPTION  = 'idxb_seo_robots_state';
	const DIRECTIVES    = array( 'user-agent', 'disallow', 'allow', 'sitemap', 'crawl-delay', 'host', 'clean-param' );

	public static function ai_bots(): array {
		return array(
			array( 'ua' => 'GPTBot', 'label' => 'OpenAI GPTBot', 'note' => 'OpenAI model training', 'def' => 'allow' ),
			array( 'ua' => 'OAI-SearchBot', 'label' => 'OpenAI OAI-SearchBot', 'note' => 'ChatGPT search results', 'def' => 'allow' ),
			array( 'ua' => 'ChatGPT-User', 'label' => 'ChatGPT-User', 'note' => 'Visits started by ChatGPT users', 'def' => 'allow' ),
			array( 'ua' => 'ClaudeBot', 'label' => 'Anthropic ClaudeBot', 'note' => 'Anthropic model training', 'def' => 'allow' ),
			array( 'ua' => 'Claude-SearchBot', 'label' => 'Claude-SearchBot', 'note' => 'Claude search results', 'def' => 'allow' ),
			array( 'ua' => 'Claude-User', 'label' => 'Claude-User', 'note' => 'Visits started by Claude users', 'def' => 'allow' ),
			array( 'ua' => 'PerplexityBot', 'label' => 'PerplexityBot', 'note' => 'Perplexity search index', 'def' => 'allow' ),
			array( 'ua' => 'Google-Extended', 'label' => 'Google-Extended', 'note' => 'Gemini / Vertex AI (does not affect Google Search)', 'def' => 'allow' ),
			array( 'ua' => 'Applebot-Extended', 'label' => 'Applebot-Extended', 'note' => 'Apple Intelligence training (does not affect Siri/Spotlight)', 'def' => 'allow' ),
			array( 'ua' => 'cohere-ai', 'label' => 'Cohere', 'note' => 'Cohere models', 'def' => 'allow' ),
			array( 'ua' => 'CCBot', 'label' => 'Common Crawl CCBot', 'note' => 'Open dataset used by many LLMs', 'def' => 'default' ),
			array( 'ua' => 'Bytespider', 'label' => 'ByteDance Bytespider', 'note' => 'ByteDance (TikTok) crawler', 'def' => 'default' ),
		);
	}

	public static function default_ai_states(): array {
		$out = array();
		foreach ( self::ai_bots() as $b ) {
			$out[ $b['ua'] ] = $b['def'];
		}
		return $out;
	}

	public static function init() {
		add_filter( 'robots_txt', array( __CLASS__, 'filter' ), PHP_INT_MAX, 2 );
		add_action( 'admin_init', array( __CLASS__, 'maybe_seed' ) );
	}

	public static function filter( $output, $public ) {
		return self::build( IDXB_SEO_Settings::get() );
	}

	/* =========================================================
	 * Builder
	 * ========================================================= */

	public static function sitemap_url(): string {
		return home_url( '/sitemap_index.xml' );
	}

	/** Managed rules for the "*" group. */
	private static function star_rules( array $r ): array {
		$rules = array();
		if ( $r['denySearch'] ) {
			array_push( $rules, 'Disallow: /?s=', 'Disallow: /*?s=' );
		}
		if ( $r['denyIdxParams'] ) {
			foreach ( array_filter( explode( "\n", $r['idxParams'] ) ) as $p ) {
				$rules[] = 'Disallow: /*?' . $p . '=';
				$rules[] = 'Disallow: /*&' . $p . '=';
			}
		}
		if ( $r['denyWpJson'] ) {
			array_push( $rules, 'Disallow: /wp-json/', 'Disallow: /?rest_route=' );
		}
		return $rules;
	}

	public static function build( array $settings ): string {
		$r     = $settings['robots'];
		$lines = array();

		if ( ! get_option( 'blog_public' ) && ! empty( $r['respectDiscourage'] ) ) {
			// Opt-in: block everything while "Discourage search engines" is on (ASCII only: the file may be served without charset).
			return implode(
				"\n",
				array(
					self::MARKER,
					'# Settings > Reading > "Discourage search engines" is on: whole site blocked.',
					'User-agent: *',
					'Disallow: /',
				)
			) . "\n";
		}

		$custom = rtrim( (string) $r['customContent'] );
		if ( '' !== $custom ) {
			$lines[] = $custom;
			$lines[] = '';
		}
		$lines[] = self::BLOCK_START;
		$lines[] = '# ---------------------------';

		$star  = self::star_rules( $r );
		$block = array();
		if ( $star ) {
			$block[] = array_merge( array( 'User-agent: *' ), $star );
		}
		if ( $r['denyAdsBot'] ) {
			$block[] = array( 'User-agent: AdsBot-Google', 'User-agent: AdsBot-Google-Mobile', 'Disallow: /' );
		}

		$allow = array();
		$deny  = array();
		foreach ( self::ai_bots() as $b ) {
			$state = $r['ai'][ $b['ua'] ] ?? 'default';
			if ( 'allow' === $state ) {
				$allow[] = 'User-agent: ' . $b['ua'];
			} elseif ( 'block' === $state ) {
				$deny[] = 'User-agent: ' . $b['ua'];
			}
		}
		if ( $allow ) {
			// A named group does NOT inherit "User-agent: *": repeat the base restrictions explicitly.
			$inherited = self::inherited_rules( $custom, $star );
			$block[]   = array_merge( $allow, $inherited ? $inherited : array( 'Allow: /' ) );
		}
		if ( $deny ) {
			$block[] = array_merge( $deny, array( 'Disallow: /' ) );
		}

		foreach ( $block as $i => $g ) {
			if ( $i > 0 ) {
				$lines[] = '';
			}
			array_push( $lines, ...$g );
		}

		if ( $settings['sitemap']['enabled'] && $r['includeSitemap'] ) {
			if ( $block ) {
				$lines[] = '';
			}
			$lines[] = 'Sitemap: ' . self::sitemap_url();
		}
		$lines[] = '# ---------------------------';
		$lines[] = self::BLOCK_END;

		return implode( "\n", $lines ) . "\n";
	}

	/** Allow/Disallow lines of every "*" group in the custom text + managed "*" rules, deduplicated. */
	private static function inherited_rules( string $custom, array $star ): array {
		$out = array();
		foreach ( self::parse( $custom ) as $g ) {
			if ( in_array( '*', $g['agents'], true ) ) {
				foreach ( $g['rules'] as $rule ) {
					$out[] = ( 'allow' === $rule['type'] ? 'Allow: ' : 'Disallow: ' ) . $rule['path'];
				}
			}
		}
		$out = array_values( array_unique( array_merge( $out, $star ) ) );
		// "Allow: /" alone is noise once there are real rules.
		if ( count( $out ) > 1 ) {
			$out = array_values( array_filter( $out, fn( $l ) => 'Allow: /' !== $l ) );
		}
		return $out;
	}

	/* =========================================================
	 * Parser + Google-style tester
	 * ========================================================= */

	public static function parse( string $text ): array {
		$groups  = array();
		$cur     = -1;
		$last_ua = false;
		foreach ( explode( "\n", str_replace( "\r", '', $text ) ) as $raw ) {
			$line = trim( preg_replace( '/#.*/', '', $raw ) );
			if ( '' === $line || ! preg_match( '/^([A-Za-z-]+)\s*:\s*(.*)$/', $line, $m ) ) {
				continue;
			}
			$d = strtolower( $m[1] );
			$v = trim( $m[2] );
			if ( 'user-agent' === $d ) {
				if ( $cur < 0 || ! $last_ua ) {
					$groups[] = array( 'agents' => array(), 'rules' => array() );
					$cur      = count( $groups ) - 1;
				}
				$groups[ $cur ]['agents'][] = strtolower( $v );
				$last_ua                    = true;
			} else {
				$last_ua = false;
				if ( ( 'allow' === $d || 'disallow' === $d ) && $cur >= 0 && '' !== $v ) {
					$groups[ $cur ]['rules'][] = array( 'type' => $d, 'path' => $v );
				}
			}
		}
		return $groups;
	}

	private static function pattern_regex( string $p ): string {
		$anchored = str_ends_with( $p, '$' );
		$body     = $anchored ? substr( $p, 0, -1 ) : $p;
		$parts    = array_map( fn( $s ) => preg_quote( $s, '#' ), explode( '*', $body ) );
		return '#^' . implode( '.*', $parts ) . ( $anchored ? '$' : '' ) . '#';
	}

	/** Most specific UA group, longest match wins, Allow wins ties (Google / RFC 9309). */
	public static function test( string $text, string $ua, string $path ): array {
		$groups = self::parse( $text );
		$u      = strtolower( trim( $ua ) );
		$path   = '' === $path ? '/' : $path;
		if ( '/' !== $path[0] ) {
			$parsed = wp_parse_url( $path );
			$path   = ( $parsed['path'] ?? '/' ) . ( isset( $parsed['query'] ) ? '?' . $parsed['query'] : '' );
		}
		$best = '';
		foreach ( $groups as $g ) {
			foreach ( $g['agents'] as $a ) {
				if ( '*' !== $a && str_starts_with( $u, $a ) && strlen( $a ) > strlen( $best ) ) {
					$best = $a;
				}
			}
		}
		$note = '';
		if ( '' === $best ) {
			if ( str_starts_with( $u, 'adsbot' ) ) {
				return array( 'allowed' => true, 'group' => '(none)', 'rule' => null, 'note' => __( 'AdsBot ignores the "*" group: it only follows rules that name it.', 'idxboost-seo' ) );
			}
			$best = '*';
		}
		$rules  = array();
		foreach ( $groups as $g ) {
			if ( in_array( $best, $g['agents'], true ) ) {
				$rules = array_merge( $rules, $g['rules'] );
			}
		}
		$winner = null;
		foreach ( $rules as $r ) {
			if ( preg_match( self::pattern_regex( $r['path'] ), $path ) ) {
				$len = strlen( str_replace( '*', '', $r['path'] ) );
				if ( ! $winner || $len > $winner['len'] || ( $len === $winner['len'] && 'allow' === $r['type'] ) ) {
					$winner = $r + array( 'len' => $len );
				}
			}
		}
		return array(
			'allowed' => ! $winner || 'allow' === $winner['type'],
			'group'   => $best,
			'rule'    => $winner ? ( 'allow' === $winner['type'] ? 'Allow: ' : 'Disallow: ' ) . $winner['path'] : null,
			'note'    => $note,
		);
	}

	/* =========================================================
	 * Linter
	 * ========================================================= */

	/** @return array list of [ level => error|warn|info, msg ] */
	public static function lint( array $settings ): array {
		$out    = array();
		$r      = $settings['robots'];
		$txt    = (string) $r['customContent'];
		$seen   = false;
		$dup_ai = array();
		$home  = strtolower( (string) wp_parse_url( home_url(), PHP_URL_HOST ) );
		$ai_uas = array();
		foreach ( self::ai_bots() as $b ) {
			if ( 'default' !== ( $r['ai'][ $b['ua'] ] ?? 'default' ) ) {
				$ai_uas[ strtolower( $b['ua'] ) ] = $b['ua'];
			}
		}

		if ( ! get_option( 'blog_public' ) ) {
			$out[] = ! empty( $r['respectDiscourage'] )
				? array( 'error', __( 'Settings > Reading > "Discourage search engines" is on and you chose to block everything: robots.txt publishes "Disallow: /" and these rules are ignored.', 'idxboost-seo' ) )
				: array( 'info', __( 'Settings > Reading > "Discourage search engines" is on: WordPress marks every page as noindex, but robots.txt publishes your rules.', 'idxboost-seo' ) );
		}

		foreach ( explode( "\n", $txt ) as $i => $raw ) {
			$n    = $i + 1;
			$line = trim( preg_replace( '/#.*/', '', $raw ) );
			if ( '' === $line ) {
				continue;
			}
			if ( ! preg_match( '/^([A-Za-z-]+)\s*:\s*(.*)$/', $line, $m ) ) {
				$out[] = array( 'warn', sprintf( __( 'Line %d: not in "directive: value" format.', 'idxboost-seo' ), $n ) );
				continue;
			}
			$d = strtolower( $m[1] );
			$v = trim( $m[2] );
			if ( ! in_array( $d, self::DIRECTIVES, true ) ) {
				$out[] = array( 'warn', sprintf( __( 'Line %1$d: unknown directive "%2$s".', 'idxboost-seo' ), $n, $m[1] ) );
			}
			if ( 'user-agent' === $d ) {
				$seen = true;
				if ( isset( $ai_uas[ strtolower( $v ) ] ) ) {
					$dup_ai[] = $v;
				}
			}
			if ( ( 'disallow' === $d || 'allow' === $d ) && ! $seen ) {
				$out[] = array( 'warn', sprintf( __( 'Line %1$d: "%2$s" appears before any User-agent and will be ignored.', 'idxboost-seo' ), $n, $m[1] ) );
			}
			if ( 'sitemap' === $d ) {
				$host = strtolower( (string) wp_parse_url( $v, PHP_URL_HOST ) );
				if ( $host && $host !== $home ) {
					$out[] = array( 'error', sprintf( __( 'Line %1$d: the Sitemap points to another domain (%2$s). This site is %3$s.', 'idxboost-seo' ), $n, $host, $home ) );
				} elseif ( $settings['sitemap']['enabled'] && $r['includeSitemap'] ) {
					$out[] = array( 'warn', sprintf( __( 'Line %d: the Sitemap line is already added automatically; this one is a duplicate.', 'idxboost-seo' ), $n ) );
				}
			}
			if ( 'crawl-delay' === $d ) {
				$out[] = array( 'info', sprintf( __( 'Line %d: Google ignores Crawl-delay.', 'idxboost-seo' ), $n ) );
			}
			if ( 'disallow' === $d && '/search/' === $v ) {
				$out[] = array( 'info', sprintf( __( 'Line %d: "Disallow: /search/" does not block the IDX /search page, only its sub-paths.', 'idxboost-seo' ), $n ) );
			}
		}
		if ( $dup_ai ) {
			$out[] = array( 'info', sprintf( __( 'Your text already has groups for %s, which are also set in AI bots. Crawlers merge both groups; you can remove them from the text and let the plugin manage them.', 'idxboost-seo' ), implode( ', ', array_unique( $dup_ai ) ) ) );
		}

		$final  = self::build( $settings );
		$groups = self::parse( $final );
		$star   = array();
		foreach ( $groups as $g ) {
			if ( in_array( '*', $g['agents'], true ) ) {
				foreach ( $g['rules'] as $rule ) {
					if ( 'disallow' === $rule['type'] ) {
						$star[] = $rule['path'];
					}
				}
			}
		}
		if ( in_array( '/', $star, true ) && ( get_option( 'blog_public' ) || empty( $r['respectDiscourage'] ) ) ) {
			array_unshift( $out, array( 'error', __( 'The "User-agent: *" group contains "Disallow: /": you are blocking the WHOLE site for every search engine.', 'idxboost-seo' ) ) );
		}
		if ( $star ) {
			// Crawlers merge every group that names them, so check the effective rules per agent.
			$by_agent = array();
			foreach ( $groups as $g ) {
				foreach ( $g['agents'] as $a ) {
					if ( '*' === $a ) {
						continue;
					}
					foreach ( $g['rules'] as $x ) {
						if ( 'disallow' === $x['type'] ) {
							$by_agent[ $a ][] = $x['path'];
						}
					}
					$by_agent[ $a ] = $by_agent[ $a ] ?? array();
				}
			}
			$leaky   = array();
			$missing = array();
			foreach ( $by_agent as $a => $paths ) {
				if ( in_array( '/', $paths, true ) ) {
					continue;
				}
				$diff = array_diff( $star, $paths );
				if ( $diff ) {
					$leaky[] = $a;
					$missing = array_unique( array_merge( $missing, $diff ) );
				}
			}
			if ( $leaky ) {
				$out[] = array( 'warn', sprintf( __( 'These bots have their own group and do not inherit "User-agent: *": %1$s. They will be able to crawl %2$s. Set them to “Allow” in AI bots or repeat the rules in their group.', 'idxboost-seo' ), implode( ', ', $leaky ), implode( ', ', array_slice( array_values( $missing ), 0, 4 ) ) . ( count( $missing ) > 4 ? '…' : '' ) ) );
			}
		}
		if ( ! $settings['sitemap']['enabled'] ) {
			$out[] = array( 'info', __( 'XML sitemaps are off, so no Sitemap line is added.', 'idxboost-seo' ) );
		}

		return array_map( fn( $w ) => array( 'level' => $w[0], 'msg' => $w[1] ), $out );
	}

	/* =========================================================
	 * Delivery: virtual vs physical file
	 * ========================================================= */

	/** Where the server reads robots.txt from: the first existing candidate, else the site root. */
	public static function file_path(): string {
		if ( ! function_exists( 'get_home_path' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}
		$candidates = array( trailingslashit( get_home_path() ) . 'robots.txt' );
		if ( ! empty( $_SERVER['DOCUMENT_ROOT'] ) ) {
			$candidates[] = trailingslashit( wp_normalize_path( sanitize_text_field( wp_unslash( $_SERVER['DOCUMENT_ROOT'] ) ) ) ) . 'robots.txt';
		}
		$candidates[] = trailingslashit( ABSPATH ) . 'robots.txt';
		foreach ( array_unique( $candidates ) as $c ) {
			if ( file_exists( $c ) ) {
				return $c;
			}
		}
		return $candidates[0];
	}

	public static function file_state(): array {
		$path    = self::file_path();
		$exists  = file_exists( $path );
		$content = $exists ? (string) file_get_contents( $path ) : ''; // phpcs:ignore
		$managed = $exists && str_contains( $content, self::MARKER );
		return array(
			'path'     => $path,
			'exists'   => $exists,
			'managed'  => $managed,
			'foreign'  => $exists && ! $managed,
			'content'  => $exists && ! $managed ? $content : '',
			'writable' => $exists ? wp_is_writable( $path ) : wp_is_writable( dirname( $path ) ),
		);
	}

	private static function file_body( array $settings ): string {
		$body = self::build( $settings );
		if ( ! str_contains( $body, self::MARKER ) ) {
			$body = self::MARKER . " - edit it in WP Admin > IDXBoost SEO > Robots.\n" . $body;
		}
		return $body;
	}

	/**
	 * Managed file edited by hand on the server? Returns its text, or '' if it matches what the plugin wrote.
	 * The comparison uses the last body we wrote (stored hash), so a settings change alone is not "drift".
	 */
	public static function drift(): string {
		$fs = self::file_state();
		if ( ! $fs['managed'] ) {
			return '';
		}
		$text = str_replace( "\r", '', (string) file_get_contents( $fs['path'] ) ); // phpcs:ignore
		$last = get_option( 'idxb_seo_robots_written' );
		if ( $last ) {
			return md5( self::normalize( $text ) ) === $last ? '' : $text;
		}
		return self::normalize( $text ) === self::normalize( self::build( IDXB_SEO_Settings::get() ) ) ? '' : $text;
	}

	/** Never lose hand edits: copy a drifted managed file aside before we overwrite or delete it. */
	private static function backup_drift() {
		if ( '' !== self::drift() ) {
			$fs = self::file_state();
			@copy( $fs['path'], $fs['path'] . '.idxb-edited-' . gmdate( 'Ymd-His' ) ); // phpcs:ignore
		}
	}

	/** Managed-file text → editor text: keeps hand-made lines, including ones typed inside the plugin block. */
	public static function import_managed( string $text ): string {
		$text   = str_replace( "\r", '', $text );
		$custom = self::clean_import( $text );
		$extra  = array();
		if ( preg_match( '/' . preg_quote( self::BLOCK_START, '/' ) . '(.*?)' . preg_quote( self::BLOCK_END, '/' ) . '/s', $text, $m ) ) {
			$generated = array_map( 'trim', explode( "\n", self::build( IDXB_SEO_Settings::get() ) ) );
			foreach ( explode( "\n", $m[1] ) as $line ) {
				$t = trim( $line );
				if ( '' !== $t && ! str_starts_with( $t, '# ---' ) && ! preg_match( '/^Sitemap\s*:/i', $t ) && ! in_array( $t, $generated, true ) ) {
					$extra[] = $t;
				}
			}
		}
		if ( $extra ) {
			$custom = rtrim( $custom ) . "\n\n" . implode( "\n", $extra ) . "\n";
		}
		return $custom;
	}

	const ORIGINAL_SUFFIX = '.idxb-original';

	/**
	 * Write the published robots.txt. A site's own file is updated in place (never renamed or deleted);
	 * the very first time, an untouched copy is kept as robots.txt.idxb-original.
	 */
	private static function write_file( array $settings, bool $adopt = false ): bool {
		$fs = self::file_state();
		if ( ( $fs['foreign'] && ! $adopt ) || ! $fs['writable'] ) {
			return false;
		}
		if ( $fs['foreign'] && ! file_exists( $fs['path'] . self::ORIGINAL_SUFFIX ) ) {
			if ( ! @copy( $fs['path'], $fs['path'] . self::ORIGINAL_SUFFIX ) ) { // phpcs:ignore
				return false; // no safety copy, no overwrite
			}
		}
		self::backup_drift();
		$body = self::file_body( $settings );
		update_option( 'idxb_seo_robots_written', md5( self::normalize( $body ) ), false );
		return false !== file_put_contents( $fs['path'], $body ); // phpcs:ignore
	}

	/** Kept for older call sites: the plugin no longer deletes robots.txt files. */
	public static function remove_managed_file() {}

	/** Comparable form: no CR, no marker lines, trimmed. */
	public static function normalize( string $t ): string {
		$lines = array_filter( explode( "\n", str_replace( "\r", '', $t ) ), fn( $l ) => ! str_starts_with( $l, self::MARKER ) );
		return trim( implode( "\n", $lines ) );
	}

	/** Loopback check: does /robots.txt reach WordPress and return our block? */
	public static function probe(): array {
		$res = wp_remote_get(
			home_url( '/robots.txt' ), // no cache-busting query: we want to see exactly what bots get, caches included
			array( 'timeout' => 8, 'sslverify' => false, 'redirection' => 2, 'headers' => array( 'Cache-Control' => 'no-cache' ) )
		);
		if ( is_wp_error( $res ) ) {
			return array( 'ok' => false, 'code' => 0, 'error' => $res->get_error_message() );
		}
		$code = (int) wp_remote_retrieve_response_code( $res );
		$body = (string) wp_remote_retrieve_body( $res );
		return array(
			// Must match the current rules, not just carry our marker: a cached old copy also has the marker.
			'ok'      => 200 === $code && self::normalize( $body ) === self::normalize( self::build( IDXB_SEO_Settings::get() ) ),
			'stale'   => 200 === $code && ( str_contains( $body, self::BLOCK_START ) || str_contains( $body, self::MARKER ) ),
			'code'    => $code,
			'error'   => '',
			'served'  => substr( $body, 0, 4000 ),
		);
	}

	/**
	 * Publish. Called on activation and on every settings save.
	 *  - The site has its own robots.txt not yet published by the plugin → leave it alone ("foreign")
	 *    until the user publishes (adopt()).
	 *  - There is a robots.txt file (ours) → always update that file in place.
	 *  - No file: "file" mode writes one; "auto" serves it from WordPress and writes the file only if
	 *    the server does not pass /robots.txt to WordPress; "virtual" never writes.
	 */
	public static function apply_mode(): array {
		$settings = IDXB_SEO_Settings::get();
		$mode     = $settings['robots']['mode'];
		$fs       = self::file_state();
		$state    = array( 'mode' => $mode, 'effective' => 'virtual', 'probe' => null, 'error' => '', 'checked' => time() );

		if ( $fs['foreign'] ) {
			$state['effective'] = 'foreign';
		} elseif ( $fs['exists'] || 'file' === $mode ) {
			$state['effective'] = self::write_file( $settings ) ? 'file' : 'error';
		} elseif ( 'auto' === $mode ) {
			$probe          = self::probe();
			$state['probe'] = $probe;
			$state['effective'] = $probe['ok'] ? 'virtual' : ( self::write_file( $settings ) ? 'file' : 'error' );
		}
		if ( 'error' === $state['effective'] ) {
			$state['error'] = sprintf( __( 'Could not write %s (permissions). Check the folder write permissions.', 'idxboost-seo' ), $fs['path'] );
		}
		update_option( self::STATE_OPTION, $state, false );
		return $state;
	}

	const BACKUP_OPTION = 'idxb_seo_robots_backup';

	/**
	 * "Publish to the site robots.txt": update the site's own file in place with the editor's rules.
	 * A copy of the untouched original is kept once as robots.txt.idxb-original.
	 */
	public static function take_control(): array {
		$fs = self::file_state();
		if ( ! $fs['foreign'] ) {
			self::apply_mode();
			return array( 'ok' => true, 'msg' => __( 'robots.txt is already published with your rules.', 'idxboost-seo' ) );
		}
		if ( ! self::write_file( IDXB_SEO_Settings::get(), true ) ) {
			return array( 'ok' => false, 'msg' => sprintf( __( 'Could not update %s (write permissions). The file was not changed.', 'idxboost-seo' ), $fs['path'] ) );
		}
		self::apply_mode();
		return array(
			'ok'  => true,
			'msg' => sprintf( __( 'Done: the site robots.txt was updated with your rules. Copy of the original: %s. Turning the plugin off does not delete it.', 'idxboost-seo' ), basename( $fs['path'] . self::ORIGINAL_SUFFIX ) ),
		);
	}

	/** Newest robots.txt.idxb-backup-* next to robots.txt (backups made by 1.0.x were not recorded). */
	private static function newest_backup(): string {
		$files = glob( dirname( self::file_path() ) . '/robots.txt.idxb-backup-*' );
		if ( ! $files ) {
			return '';
		}
		rsort( $files ); // names end in Ymd-His, so the newest sorts first
		return $files[0];
	}

	/** On deactivation: put the site's original robots.txt back if we moved it aside. */
	public static function restore_backup() {
		$b        = get_option( self::BACKUP_OPTION );
		$original = self::file_path();
		$backup   = is_array( $b ) && ! empty( $b['backup'] ) ? $b['backup'] : self::newest_backup();
		if ( is_array( $b ) && ! empty( $b['original'] ) ) {
			$original = $b['original'];
		}
		if ( $backup && file_exists( $backup ) && ! file_exists( $original ) ) {
			@rename( $backup, $original ); // phpcs:ignore
		}
		delete_option( self::BACKUP_OPTION );
	}

	/**
	 * On activation: a site left without robots.txt by an older version (backup not recorded, file removed
	 * on deactivation) gets its original back before anything else runs.
	 */
	public static function heal_orphan_backup() {
		if ( get_option( self::BACKUP_OPTION ) || file_exists( self::file_path() ) ) {
			return;
		}
		$backup = self::newest_backup();
		if ( $backup ) {
			@rename( $backup, self::file_path() ); // phpcs:ignore
		}
	}

	/**
	 * Text coming from outside (live site, old file, another plugin) → editor content:
	 * drops this plugin's own block/marker and Sitemap lines (the plugin writes its own).
	 */
	public static function clean_import( string $text ): string {
		$text = str_replace( array( "\r\n", "\r" ), "\n", $text );
		$text = preg_replace( '/' . preg_quote( self::BLOCK_START, '/' ) . '.*?' . preg_quote( self::BLOCK_END, '/' ) . '/s', '', $text );
		$text = preg_replace( '/^' . preg_quote( self::MARKER, '/' ) . '.*$/m', '', $text );
		$text = preg_replace( '/^\s*Sitemap\s*:.*$/mi', '', $text );
		$text = preg_replace( "/\n{3,}/", "\n\n", trim( $text ) );
		return '' === $text ? '' : $text . "\n";
	}

	/** What WordPress + other plugins (Yoast, Rank Math…) would serve as virtual robots.txt without this plugin. */
	public static function others_virtual(): string {
		$site = wp_parse_url( site_url() );
		$path = ! empty( $site['path'] ) ? $site['path'] : '';
		$out  = "User-agent: *\nDisallow: $path/wp-admin/\nAllow: $path/wp-admin/admin-ajax.php\n";
		remove_filter( 'robots_txt', array( __CLASS__, 'filter' ), PHP_INT_MAX );
		$out = (string) apply_filters( 'robots_txt', $out, (string) get_option( 'blog_public' ) );
		add_filter( 'robots_txt', array( __CLASS__, 'filter' ), PHP_INT_MAX, 2 );
		return $out;
	}

	/** Sources the editor can load from (live text is fetched by the browser). */
	public static function sources(): array {
		$fs = self::file_state();
		return array(
			'file'       => $fs['exists'] ? str_replace( "\r", '', (string) file_get_contents( $fs['path'] ) ) : '', // phpcs:ignore
			'filePath'   => $fs['path'],
			'fileManaged'=> $fs['managed'],
			'fileImport' => $fs['exists'] ? ( $fs['managed'] ? self::import_managed( (string) file_get_contents( $fs['path'] ) ) : self::clean_import( (string) file_get_contents( $fs['path'] ) ) ) : '', // phpcs:ignore
			'others'     => self::others_virtual(),
		);
	}

	const SEED_OPTION = 'idxb_seo_robots_seeded';

	/** Runs once per site (activation, or first admin load after updating from 1.0.x). */
	public static function maybe_seed() {
		if ( false === get_option( self::SEED_OPTION, false ) && current_user_can( 'manage_options' ) ) {
			self::seed_from_site();
		}
	}

	/** Robots.txt the site serves over HTTP right now, if it is not ours. */
	private static function live_external(): string {
		$res = wp_remote_get(
			add_query_arg( 'idxb_seed', time(), home_url( '/robots.txt' ) ),
			array( 'timeout' => 8, 'sslverify' => false, 'redirection' => 3, 'headers' => array( 'Cache-Control' => 'no-cache' ) )
		);
		if ( is_wp_error( $res ) || 200 !== (int) wp_remote_retrieve_response_code( $res ) ) {
			return '';
		}
		$body = (string) wp_remote_retrieve_body( $res );
		$type = (string) wp_remote_retrieve_header( $res, 'content-type' );
		if ( str_contains( $body, self::BLOCK_START ) || str_contains( $body, self::MARKER ) || str_contains( $type, 'html' ) ) {
			return ''; // ours, or an HTML error page
		}
		return $body;
	}

	/**
	 * Load the site's existing robots.txt into the editor. Order:
	 *  1. physical robots.txt on the server   2. what the site serves over HTTP (server rule, CDN…)
	 *  3. rules added by other plugins (Yoast, Rank Math…)
	 * Nothing found → keep the plugin's generated default.
	 * Never overwrites content the user already edited.
	 */
	public static function seed_from_site(): array {
		$settings = IDXB_SEO_Settings::get();
		$default  = IDXB_SEO_Settings::defaults()['robots']['customContent'];
		$edited   = trim( (string) $settings['robots']['customContent'] ) !== trim( $default );
		$result   = array( 'source' => 'default', 'at' => time() );

		if ( $edited && false !== get_option( IDXB_SEO_Settings::OPTION, false ) ) {
			$result['source'] = 'kept';
		} else {
			$fs   = self::file_state();
			$text = '';
			if ( $fs['exists'] && ! $fs['managed'] ) {
				$text = self::clean_import( (string) $fs['content'] );
				$result['source'] = 'file';
				$result['path']   = $fs['path'];
			}
			if ( '' === $text ) {
				$text = self::clean_import( self::live_external() );
				$result['source'] = 'live';
			}
			if ( '' === $text ) {
				$others = self::clean_import( self::others_virtual() );
				// Only if another plugin changed WordPress' 3-line default.
				if ( substr_count( trim( $others ), "\n" ) > 2 ) {
					$text             = $others;
					$result['source'] = 'plugins';
				}
			}
			if ( '' === $text ) {
				$result['source'] = 'default';
				$text             = $default;
			}
			$settings['robots']['customContent'] = $text;
			IDXB_SEO_Settings::save( $settings );
		}
		if ( 'file' !== $result['source'] ) {
			unset( $result['path'] );
		}
		update_option( self::SEED_OPTION, $result, false );
		return $result;
	}

	public static function status(): array {
		$state = get_option( self::STATE_OPTION, array() );
		$fs    = self::file_state();
		unset( $fs['content'] );
		return array(
			'state'       => is_array( $state ) ? $state : array(),
			'file'        => $fs,
			'foreignText' => self::file_state()['content'],
			'blogPublic'  => (bool) get_option( 'blog_public' ),
			'seed'        => get_option( self::SEED_OPTION, null ),
			'url'         => home_url( '/robots.txt' ),
			'expected'    => self::build( IDXB_SEO_Settings::get() ),
			'drift'       => '' !== self::drift(),
		);
	}
}
