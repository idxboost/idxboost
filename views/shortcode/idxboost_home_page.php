<?php
get_header();
global $flex_idx_info;

$response = wp_remote_post(IDX_BOOST_SPW_BUILDER_SERVICE . '/api/page-template', array(
        'method' => 'POST',
        'timeout' => 60,
        'headers' => [
            'Content-Type' => 'application/json',
        ],
        'body' => wp_json_encode([
            'registration_key' => get_option('idxboost_registration_key'),
            'page_type' => 'home'
        ])
    )
);
$body = wp_remote_retrieve_body($response);
$content = json_decode($body, true);
if (is_wp_error($response) or $content == NULL) {
    idx_page_404();
    die();
} else {
    idx_page_shortcode_render($content['content']);
}
get_footer();