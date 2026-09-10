<?php 

get_header();

global $post, $flex_idx_info;

$filter_type = "listing";

if ( 
    ! empty( $_GET ) && 
    is_array( $_GET ) && 
    array_key_exists( "type", $_GET ) && 
    $_GET["type"] 
) {
	$filter_type = $_GET["type"];
}

$agent_registration_key = get_post_meta( $post->ID, "_flex_agent_registration_key", true );
$agent_page_slug = $post->post_name;
$agent_full_info = [];

if ( 
    isset( $agent_registration_key ) && 
    ! empty( $agent_registration_key ) 
) {
    $agent_full_info = wp_remote_get( sprintf( '%s/crm/agents/info/%s', FLEX_IDX_BASE_URL, $agent_registration_key ), ['timeout' => IDXBOOST_HTTP_TIMEOUT_RENDER] );
    $agent_full_info = ( is_wp_error( $agent_full_info ) ) ? [] : wp_remote_retrieve_body( $agent_full_info );

    if ( ! empty( $agent_full_info ) ) {
        $agent_full_info = json_decode( $agent_full_info, true );
    }
}

if ( ! $agent_full_info ) {
    status_header(404);
    nocache_headers();
    include(get_query_template('404'));
    die();
} else {

    $data = array(
        'registration_key' => get_option('idxboost_registration_key'),
        'agent_id' => $agent_full_info['info']['id'],
        'filter_type' => $filter_type
    );
    $payload = json_encode($data);

    // Prepare new cURL resource
    $response = wp_remote_post(IDX_BOOST_SPW_BUILDER_SERVICE_AGENT_INFO, array(
        'timeout'     => IDXBOOST_HTTP_TIMEOUT_RENDER,
        'redirection' => 0,
        'headers' => array(
            'Content-Type' => 'application/json',
            'Referer'      => ib_get_http_referer(),
        ),
        'body'    => $payload,
    ));

    $result   = is_wp_error($response) ? false : wp_remote_retrieve_body($response);
    $httpcode = is_wp_error($response) ? 0 : wp_remote_retrieve_response_code($response);
    
    if ($httpcode == 200) {
        $jsonObj = json_decode($result);

        // Evita un Fatal Error (Attempt to read property "content" on null)
        // cuando el API responde 200 con un cuerpo vacio o JSON invalido/
        // inesperado. Ante esa condicion se cae a la misma pantalla de
        // "no encontrado" que ya usan el resto de los casos de esta vista.
        if (json_last_error() !== JSON_ERROR_NONE || !is_object($jsonObj)) {
            status_header(404);
            nocache_headers();
            include(get_query_template('404'));
            die();
        }

        if (
            $jsonObj->content != null && 
            trim($jsonObj->content) != ""
        ) {

            $pattern = '~\[idx_boost_agent_office agent_id="(.+?)"\]~';
            if (preg_match($pattern, $jsonObj->content, $match)) {
                $ib_agent_filter = do_shortcode($match[0]);
                $jsonObj->content = str_replace($match[0], $ib_agent_filter, $jsonObj->content);
            }

            $pattern = '~\[idx_boost_agent_office office_id="(.+?)"\]~';
            if (preg_match($pattern, $jsonObj->content, $match)) {
                $ib_office_filter = do_shortcode($match[0]);
                $jsonObj->content = str_replace($match[0], $ib_office_filter, $jsonObj->content);
            }

            $pattern = '~\[idx_boost_agent_office_sold office_id="(.+?)" months_back="(.+?)"\]~';
            if (preg_match($pattern, $jsonObj->content, $match)) {
                $ib_office_sold_filter = do_shortcode($match[0]);
                $jsonObj->content = str_replace($match[0], $ib_office_sold_filter, $jsonObj->content);
            }

            $pattern = '~\[idx_boost_agent_office_sold agent_id="(.+?)" months_back="(.+?)"\]~';
            if (preg_match($pattern, $jsonObj->content, $match)) {
                $ib_office_sold_filter = do_shortcode($match[0]);
                $jsonObj->content = str_replace($match[0], $ib_office_sold_filter, $jsonObj->content);
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