<?php get_header();

global $post, $flex_idx_info;

//wp_enqueue_script('idx_boost_js_contact', IDX_BOOST_SPW_BUILDER_SERVICE . '/assets/js/agent.js', array(), false, true);
wp_enqueue_style('idx_boost_style_contact', IDX_BOOST_SPW_BUILDER_SERVICE . '/assets/css/agent.css');

$agent_registration_key = get_post_meta($post->ID, "_flex_agent_registration_key", true);
$agent_page_slug = $post->post_name;
$agent_full_info = [];
/*
if ("idx-agents" === $post->post_type) {
    list($agent_name) = explode("/", $wp->request);
    $agent_full_slugname = implode("/", [site_url(), $agent_name]);
}
*/

if (isset($agent_registration_key) && !empty($agent_registration_key)) {
    $agent_full_info = wp_remote_get(sprintf('%s/crm/agents/info/%s', FLEX_IDX_BASE_URL, $agent_registration_key), ['timeout' => 10]);
    $agent_full_info = (is_wp_error($agent_full_info)) ? [] : wp_remote_retrieve_body($agent_full_info);

    if (!empty($agent_full_info)) {
        $agent_full_info = json_decode($agent_full_info, true);
    }
}


if (!$agent_full_info) {
    status_header(404);
    nocache_headers();
    include(get_query_template('404'));
    die();
} else {
    $data = array(
        'registration_key' => get_option('idxboost_registration_key'),
        'agent_id' => $agent_full_info['info']['id'],
    );
    $payload = json_encode($data);

// Prepare new cURL resource
    $ch = curl_init(IDX_BOOST_SPW_BUILDER_SERVICE_AGENT_INFO);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

// Set HTTP Header for POST request
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
    );

// Submit the POST request
    $result = curl_exec($ch);


    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Close cURL session handle
    curl_close($ch);
    if ($httpcode == 200) {
        $jsonObj = json_decode($result);
        if ($jsonObj->content != null && trim($jsonObj->content) != "") {
            $pattern = '~\[idx_agent_filter id="(.+?)" type="agent"\]~';
            if (preg_match($pattern, $jsonObj->content, $match)) {
                $variable = do_shortcode($match[0]);
                $jsonObj->content = str_replace($match[0], $variable, $jsonObj->content);
            }

            echo '<div class="flex_ix_agent_page">';
            echo $jsonObj->content;
            echo '</div>';
        } else {
            status_header(404);
            nocache_headers();
            include(get_query_template('404'));
            die();
        }
    } else {
        status_header(404);
        nocache_headers();
        include(get_query_template('404'));
        die();
    }
}

get_footer();