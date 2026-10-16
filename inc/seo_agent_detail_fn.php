<?php
/**
 * SEO automático del detalle de agente (/agent/{slug}): title, description,
 * Open Graph, Twitter, canonical y JSON-LD con los datos del IDX.
 * No depende de "Active SEO" del CMS. Slug inexistente → 404.
 */
if (!function_exists('idxboost_agent_detail_state')) {
    function idxboost_agent_detail_state($new_state = null)
    {
        static $state = null;

        if (null !== $new_state) {
            $state = $new_state;
        }

        return $state;
    }
}

if (!function_exists('idxboost_agent_detail_owns_head')) {
    function idxboost_agent_detail_owns_head()
    {
        return null !== idxboost_agent_detail_state();
    }
}

if (!function_exists('idxboost_get_agent_detail')) {
    function idxboost_get_agent_detail($slug)
    {
        static $cache = array();

        $slug = (string) $slug;

        if (array_key_exists($slug, $cache)) {
            return $cache[$slug];
        }

        $service_agent_detail = str_replace('{{registrationKey}}', get_option('idxboost_registration_key'), FLEX_IDX_API_LOOKUP_GET_AGENTS_DETAIL);

        $curl_body = idxboost_remote_request($service_agent_detail, array(
            'timeout'     => IDXBOOST_HTTP_TIMEOUT_RENDER,
            'redirection' => 10,
            'httpversion' => '1.1',
            'headers'     => array(
                'Content-Type' => 'application/json',
            ),
            'body'        => json_encode(array('slug' => $slug)),
        ));

        $response = is_string($curl_body) && '' !== $curl_body ? json_decode($curl_body, true) : null;

        $cache[$slug] = is_array($response) ? $response : null;

        return $cache[$slug];
    }
}

if (!function_exists('idxboost_agent_detail_has_data')) {
    function idxboost_agent_detail_has_data($response)
    {
        return is_array($response)
            && !empty($response['success'])
            && isset($response['data'])
            && is_array($response['data'])
            && count($response['data']) > 0;
    }
}

if (!function_exists('idxboost_agent_detail_template_redirect')) {
    function idxboost_agent_detail_template_redirect()
    {
        global $wp, $wp_query;

        if (is_admin() || !is_singular('flex-idx-pages')) {
            return;
        }

        $page = get_queried_object();

        if (!($page instanceof WP_Post) || 'flex_idx_agent_detail' !== get_post_meta($page->ID, '_flex_id_page', true)) {
            return;
        }

        if ('active' !== get_option('idxboost_client_status')) {
            return;
        }

        $segments = explode('/', (string) $wp->request);
        $slug = isset($segments[1]) ? trim($segments[1]) : '';

        $response = '' !== $slug ? idxboost_get_agent_detail($slug) : null;

        if ('' === $slug) {
            $status = 'not_found';
        } elseif (null === $response) {
            $status = 'error';
        } elseif (idxboost_agent_detail_has_data($response)) {
            $status = 'found';
        } else {
            $status = 'not_found';
        }

        idxboost_agent_detail_state(array(
            'status'   => $status,
            'page_id'  => $page->ID,
            'slug'     => $slug,
            'response' => $response,
        ));

        if ('not_found' === $status) {
            $wp_query->set_404();
            status_header(404);
            nocache_headers();
        } else {
            if ('error' === $status) {
                nocache_headers();
            }

            // El canonical de core apuntaría a /agent/ para todos; Yoast y Rank Math solo conocen la página genérica.
            remove_action('wp_head', 'rel_canonical');
            add_filter('wpseo_frontend_presenters', '__return_empty_array', 99);
            remove_all_actions('wpseo_head');
            remove_all_actions('rank_math/head');

            add_filter('pre_get_document_title', 'idxboost_agent_detail_document_title', 99);
            add_filter('wp_title', 'idxboost_agent_detail_document_title', 99);
        }

        add_action('wp_head', 'idxboost_agent_detail_print_head', 1);
    }

    add_action('template_redirect', 'idxboost_agent_detail_template_redirect', 5);
}

if (!function_exists('idxboost_agent_detail_seo')) {
    function idxboost_agent_detail_seo()
    {
        static $seo = null;

        if (null !== $seo) {
            return $seo;
        }

        $state = idxboost_agent_detail_state();

        if (null === $state || 'not_found' === $state['status']) {
            return null;
        }

        $site_name = html_entity_decode(wp_strip_all_tags(get_bloginfo('name')), ENT_QUOTES, 'UTF-8');
        $agent = 'found' === $state['status'] ? $state['response']['data'] : array();

        $text = function ($key) use ($agent) {
            if (!isset($agent[$key]) || !is_scalar($agent[$key])) {
                return '';
            }

            // \p{Cf}: caracteres de formato invisibles (p. ej. U+202C) que vienen en los datos.
            $value = preg_replace('/[\p{Cf}]/u', '', html_entity_decode(wp_strip_all_tags((string) $agent[$key]), ENT_QUOTES, 'UTF-8'));

            return trim(preg_replace('/\s+/u', ' ', $value));
        };

        $first_name = $text('firstName');
        $last_name = $text('lastName');
        $full_name = trim($first_name . ' ' . $last_name);
        $position = $text('title');

        $canonical_slug = '' !== $text('agentSlug') ? $text('agentSlug') : $state['slug'];
        $canonical = user_trailingslashit(trailingslashit(get_permalink($state['page_id'])) . rawurlencode($canonical_slug));

        if ('' === $full_name) {
            $og_title = wp_strip_all_tags(get_the_title($state['page_id']));
        } else {
            $og_title = $full_name;
        }

        $title = $og_title . ('' !== $site_name ? ' | ' . $site_name : '');

        $description = '';
        if ('found' === $state['status']) {
            $description = $text('biography');

            if ('' === $description && '' !== $full_name) {
                $description = sprintf(
                    /* translators: 1: agent name, 2: agent position, 3: site name, 4: agent first name */
                    __('%1$s%2$s at %3$s. Contact %4$s and browse featured listings and recently sold properties.', IDXBOOST_DOMAIN_THEME_LANG),
                    $full_name,
                    '' !== $position ? ', ' . $position : '',
                    $site_name,
                    '' !== $first_name ? $first_name : $full_name
                );
            }

            $description = idxboost_agent_detail_truncate($description, 156);
        }

        $avatar = isset($agent['avatar']) ? idxboost_agent_detail_absolute_url($agent['avatar']) : '';
        $logo = idxboost_agent_detail_site_logo();

        $image = '' !== $avatar ? $avatar : $logo;

        $seo = array(
            'title'       => $title,
            'og_title'    => $og_title,
            'description' => $description,
            'image'       => $image,
            'image_is_logo' => '' === $avatar && '' !== $logo,
            'avatar'      => $avatar,
            'logo'        => $logo,
            'position'    => $position,
            'canonical'   => $canonical,
            'first_name'  => $first_name,
            'last_name'   => $last_name,
            'site_name'   => $site_name,
        );

        $seo = apply_filters('idxboost_agent_detail_seo', $seo, $agent, $state['status']);

        return $seo;
    }
}

if (!function_exists('idxboost_agent_detail_absolute_url')) {
    function idxboost_agent_detail_absolute_url($value)
    {
        $value = is_string($value) ? trim($value) : '';

        if (0 === strpos($value, '//')) {
            $value = 'https:' . $value;
        }

        return preg_match('#^https?://[^\s"\'<>]+$#i', $value) ? $value : '';
    }
}

if (!function_exists('idxboost_agent_detail_site_logo')) {
    function idxboost_agent_detail_site_logo()
    {
        global $flex_idx_info;

        $candidates = array();

        $custom_logo_id = get_theme_mod('custom_logo');
        if ($custom_logo_id) {
            $candidates[] = wp_get_attachment_image_url($custom_logo_id, 'full');
        }

        if (is_array($flex_idx_info)) {
            if (!empty($flex_idx_info['agent']['agent_logo_file'])) {
                $candidates[] = $flex_idx_info['agent']['agent_logo_file'];
            }
            if (!empty($flex_idx_info['agent']['broker_logo_file'])) {
                $candidates[] = $flex_idx_info['agent']['broker_logo_file'];
            }
            if (!empty($flex_idx_info['url_logo'])) {
                $candidates[] = $flex_idx_info['url_logo'];
            }
        }

        foreach ($candidates as $candidate) {
            $candidate = idxboost_agent_detail_absolute_url($candidate);
            if ('' !== $candidate) {
                return $candidate;
            }
        }

        return '';
    }
}

if (!function_exists('idxboost_agent_detail_truncate')) {
    function idxboost_agent_detail_truncate($text, $max)
    {
        if (mb_strlen($text, 'UTF-8') <= $max) {
            return $text;
        }

        // $max incluye el "…". Se toma un carácter extra para saber si la última palabra quedó completa.
        $room = $max - 1;
        $cut = mb_substr($text, 0, $room + 1, 'UTF-8');
        $at_word = preg_replace('/\s+\S*$/u', '', $cut);

        if (is_string($at_word) && $at_word !== $cut && '' !== trim($at_word)) {
            $cut = $at_word;
        } else {
            $cut = mb_substr($text, 0, $room, 'UTF-8');
        }

        $cut = rtrim($cut, " \t\n\r\0\x0B,.;:-");

        return $cut . '…';
    }
}

if (!function_exists('idxboost_agent_detail_document_title')) {
    function idxboost_agent_detail_document_title($title = '')
    {
        $seo = idxboost_agent_detail_seo();

        return null !== $seo ? $seo['title'] : $title;
    }
}

if (!function_exists('idxboost_agent_detail_print_head')) {
    function idxboost_agent_detail_print_head()
    {
        $state = idxboost_agent_detail_state();

        if (null === $state) {
            return;
        }

        // Builder CMS no declara title-tag: el <title> lo imprimía custom_seo_page().
        $print_title = !current_theme_supports('title-tag') && 'Builder CMS' === wp_get_theme()->name;

        if ('not_found' === $state['status']) {
            if ($print_title) {
                echo '<title>' . esc_html(wp_get_document_title()) . '</title>' . "\n";
            }
            echo '<meta name="robots" content="noindex, follow" />' . "\n";
            return;
        }

        $seo = idxboost_agent_detail_seo();

        if ($print_title) {
            echo '<title>' . esc_html($seo['title']) . '</title>' . "\n";
        }

        echo '<link rel="canonical" href="' . esc_url($seo['canonical']) . '" />' . "\n";

        if ('found' !== $state['status']) {
            return;
        }

        $tags = array();

        if ('' !== $seo['description']) {
            $tags[] = array('name', 'description', $seo['description']);
        }

        $tags[] = array('property', 'og:type', 'profile');
        $tags[] = array('property', 'og:title', $seo['title']);
        $tags[] = array('property', 'og:url', $seo['canonical']);
        if ('' !== $seo['site_name']) {
            $tags[] = array('property', 'og:site_name', $seo['site_name']);
        }
        if ('' !== $seo['description']) {
            $tags[] = array('property', 'og:description', $seo['description']);
        }
        if ('' !== $seo['image']) {
            $tags[] = array('property', 'og:image', $seo['image']);
            $tags[] = array('property', 'og:image:alt', $seo['image_is_logo'] && '' !== $seo['site_name'] ? $seo['site_name'] : $seo['og_title']);
        }
        if ('' !== $seo['first_name']) {
            $tags[] = array('property', 'profile:first_name', $seo['first_name']);
        }
        if ('' !== $seo['last_name']) {
            $tags[] = array('property', 'profile:last_name', $seo['last_name']);
        }

        $tags[] = array('name', 'twitter:card', '' !== $seo['image'] && !$seo['image_is_logo'] ? 'summary_large_image' : 'summary');
        $tags[] = array('name', 'twitter:title', $seo['title']);
        if ('' !== $seo['description']) {
            $tags[] = array('name', 'twitter:description', $seo['description']);
        }
        if ('' !== $seo['image']) {
            $tags[] = array('name', 'twitter:image', $seo['image']);
        }

        foreach ($tags as $tag) {
            list($attr, $key, $value) = $tag;
            $value = in_array($key, array('og:url', 'og:image', 'twitter:image'), true) ? esc_url($value) : esc_attr($value);
            echo '<meta ' . $attr . '="' . esc_attr($key) . '" content="' . $value . '" />' . "\n";
        }

        $schema = idxboost_agent_detail_schema();

        // JSON_HEX_TAG: evita que un "</script>" en los datos cierre el bloque.
        $json = !empty($schema)
            ? wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG)
            : false;

        if (is_string($json) && '' !== $json) {
            echo '<script type="application/ld+json">' . $json . '</script>' . "\n";
        }
    }
}

if (!function_exists('idxboost_agent_detail_schema')) {
    function idxboost_agent_detail_schema()
    {
        $state = idxboost_agent_detail_state();
        $seo = idxboost_agent_detail_seo();

        if (null === $state || 'found' !== $state['status'] || null === $seo) {
            return null;
        }

        $agent = $state['response']['data'];

        $name = trim($seo['first_name'] . ' ' . $seo['last_name']);

        if ('' === $name) {
            return null;
        }

        $telephone = isset($agent['phone']) && is_scalar($agent['phone'])
            ? trim(preg_replace('/[\p{Cf}]/u', '', wp_strip_all_tags((string) $agent['phone'])))
            : '';

        $works_for = array_filter(array(
            '@type' => 'RealEstateAgent',
            'name'  => $seo['site_name'],
            'url'   => trailingslashit(home_url()),
            'logo'  => $seo['logo'],
        ), 'idxboost_agent_detail_not_empty');

        $person = array_filter(array(
            '@context'  => 'https://schema.org',
            '@type'     => 'Person',
            'name'      => $name,
            'jobTitle'  => $seo['position'],
            'image'     => $seo['avatar'],
            'url'       => $seo['canonical'],
            'telephone' => $telephone,
            'worksFor'  => count($works_for) > 1 ? $works_for : null,
        ), 'idxboost_agent_detail_not_empty');

        return apply_filters('idxboost_agent_detail_schema', $person, $agent, $seo);
    }
}

if (!function_exists('idxboost_agent_detail_not_empty')) {
    function idxboost_agent_detail_not_empty($value)
    {
        return null !== $value && '' !== $value && array() !== $value;
    }
}