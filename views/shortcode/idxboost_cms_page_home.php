<?php
global $flex_idx_info, $post;

$url = IDX_BOOST_SPW_BUILDER_SERVICE . '/api/page-template';
$args = array(
    'method'    => 'POST',
    'timeout'   => 60,
    'headers'   => array(
        'Content-Type' => 'application/json',
    ),
    'body'      => wp_json_encode( array(
        'registration_key'  => get_option( 'idxboost_registration_key' ),
        'page_type'         => 'home'
    ))
);

$response = wp_remote_post( $url, $args );
$response_code = wp_remote_retrieve_response_code( $response );

if ( ! is_wp_error( $response ) && $response_code === 200 ) {
    
    $body = json_decode( wp_remote_retrieve_body( $response ), true );
    
    if ( isset( $body['content'] ) && ! empty( $body['content'] ) ) {        
        $post->post_content = idx_page_shortcode_render( $body['content'] );
    } else {
        idxboost_cms_page_under_construction();
        exit();
    }
    
} else {
    idxboost_cms_page_under_maintenance();
    exit();
}

get_header();

the_content();

get_footer();