<?php
get_header();

global $flex_idx_info, $post;

$response = wp_remote_post(
    IDX_BOOST_SPW_BUILDER_SERVICE . '/api/page-template',
    array(
        'method'  => 'POST',
        'timeout' => 60,
        'headers' => [
            'Content-Type' => 'application/json',
        ],
        'body' => wp_json_encode(array(
            'registration_key' => get_option('idxboost_registration_key'),
            "page_type"        => get_post_meta($post->ID, 'idx_page_type')[0],
            "page_id"          => get_post_meta($post->ID, 'idx_page_id')[0]
        ))
    )
);
$body    = wp_remote_retrieve_body($response);
$content = json_decode($body, true);

if (is_wp_error($response) || $content == NULL) {
    idx_page_404();
    exit;
} else {
    idx_page_shortcode_render($content['pages'][0]['content']);
}

get_footer();
