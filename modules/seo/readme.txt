=== IDXBoost SEO ===
Requires at least: 6.0
Requires PHP: 8.0
Stable tag: 1.4.0

XML sitemaps (including IDX /property/ detail pages) and a robots.txt editor for IDXBoost sites.
Works as a standalone plugin or as an IDXBoost module (modules/seo, off by default).

== Screens ==
IDXBoost SEO > Sitemap · Robots · Tools (inside IDXBoost: IDX Boost > SEO: Sitemap & Robots).
Changes show in the preview right away and go live with "Save changes".

== Sitemaps ==
* /sitemap_index.xml + {type}-sitemap{n}.xml for every public content type (flex-idx-building, flex-filter-pages, idx-agents…), taxonomies, authors and IDX properties (idx-property-sitemap.xml).
* Respects Yoast and Rank Math noindex/canonical settings and the "Exclude from XML sitemaps" box on each post.
* Exclusion by path (exact, or ending in *), by post ID and by term ID. Excluded by default: /property/ (template page only) and account pages (/my-saved-*, /my-profile).
* "Replace other plugins sitemaps" turns off the WordPress, Yoast and Rank Math sitemaps; /sitemap.xml and /wp-sitemap.xml redirect (301) to the index.
* Versioned cache, cleared automatically when content is published, edited or deleted.

== IDX properties ==
Detail pages are not WordPress posts: they are synced in the background (WP-Cron) into the {prefix}idxb_seo_listings table and the sitemap is served from there.
If the service fails or returns 0 properties, the previous ones are kept.

Option A — JSON endpoint (from the admin): URL with {page} and {per_page}, list path and URL/slug/date/images fields. The URL template accepts any field: /property/{address}-{mls_num}

Option B — From code, with the real IDXBoost client:

add_filter( 'idxb_seo_idx_fetch_page', function ( $result, $page, $idx ) {
	$data = my_idx_client()->listings( $page, $idx['perPage'] ); // example
	return array(
		'items'    => array_map( fn( $l ) => array(
			'key'     => $l['mls_num'],
			'url'     => home_url( '/property/' . $l['slug'] ),
			'lastmod' => $l['updated_at'],          // timestamp or date
			'images'  => $l['photos'],              // URLs
		), $data['items'] ),
		'has_more' => $data['has_more'],
	);
}, 10, 3 );

Other filters: idxb_seo_idx_item, idxb_seo_post_entry, idxb_seo_post_images, idxb_seo_sitemap_providers.

== robots.txt ==
* On install it reads the existing robots.txt into the editor, in this order: physical file on the server, what the site serves over HTTP (server rule/CDN), rules from other plugins (Yoast, Rank Math). If none is found, a default one is generated. Content you already edited is never overwritten.
* An existing robots.txt is respected: it is not modified until "Publish to the site robots.txt", which updates that same file (an untouched copy is saved first as robots.txt.idxb-original). It is never renamed or deleted.
* Free editor + managed block (# START/END IDXBOOST BLOCK): internal search, IDX search parameters, REST API, AdsBot-Google, AI bots (No rule / Allow / Block) and a Sitemap line with the real domain.
* Bots set to "Allow" get a group that repeats the User-agent: * restrictions (a named group does not inherit them).
* Linter and URL tester (Google rules: most specific group, longest rule, Allow wins ties).
* Detects a stale (cached) robots.txt and files edited by hand on the server (with "Pull changes into the editor").
* Honors Settings > Reading > "Discourage search engines" only if "Block everything while Discourage is on" is enabled.
* Turning off or uninstalling the plugin/module leaves robots.txt exactly as published.
