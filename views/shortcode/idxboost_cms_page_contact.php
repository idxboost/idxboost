<?php 
get_header();

global $flex_idx_info;

$url = IDX_BOOST_SPW_BUILDER_SERVICE . '/api/page-template';
$args = array(
    'method'    => 'POST',
    'timeout'   => 60,
    'headers'   => array(
        'Content-Type' => 'application/json',
    ),
    'body'      => wp_json_encode( array(
        'registration_key'  => get_option( 'idxboost_registration_key' ),
        'page_type'         => 'contact'
    ))
);

$response = wp_remote_post( $url, $args );
$response_code = wp_remote_retrieve_response_code( $response );

if ( ! is_wp_error( $response ) && $response_code === 200 ) {
    
    $body = json_decode( wp_remote_retrieve_body( $response ), true );
    
    if ( isset( $body['content'] ) && ! empty( $body['content'] ) ) {

        $show_map = $body['sections']['map']['isVisible'];

        if ( $show_map ) {
            wp_enqueue_script( 'google-maps-api' );
        }

        echo $body['content'];
        
    } else {
        idxboost_cms_page_under_construction();
    }
    
} else {
    idxboost_cms_page_under_maintenance();
    die();
}