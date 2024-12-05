<?php

$result = idxboost_cms_get_header_footer();

$variable = do_shortcode("[idxboost_dinamic_menu]");

if ( is_array($result) && count($result) > 0 ) {
    if (
        array_key_exists('data', $result) && 
        array_key_exists('footer', $result['data']) && 
        ! empty($result['data']['footer']['content'])
    ) {
        echo $result['data']['footer']['content'];
    }    
}
