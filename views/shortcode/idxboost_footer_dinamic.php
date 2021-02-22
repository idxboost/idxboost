<?php
$result = [];
if (!empty($GLOBALS) && array_key_exists('idx_header_footer', $GLOBALS) && !empty($GLOBALS['idx_header_footer'])) {
    $result = $GLOBALS['idx_header_footer'];
} else {


    $data = array(
        'registration_key' => get_option('idxboost_registration_key')
    );

    $payload = json_encode($data);
    $ch = curl_init(IDX_BOOST_SPW_BUILDER_SERVICE . '/api/page-header-footer');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    // Set HTTP Header for POST request
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($payload))
    );

    $result = @json_decode(curl_exec($ch), true);
    $GLOBALS['idx_header_footer'] = $result;
    curl_close($ch);

}


$variable = do_shortcode("[idxboost_dinamic_menu]");
$variable_idxboost_social_network_dinamic_footer = do_shortcode('[idxboost_social_network_dinamic_footer]');


// Close cURL session handle

if (is_array($result) && count($result) > 0) {
    if (array_key_exists('data', $result) && array_key_exists('footer', $result['data']) && !empty($result['data']['footer']['content'])) {
        $result['data']['footer']['content'] = str_replace("[idxboost_dinamic_menu]", $variable, $result['data']['footer']['content']);
        $result['data']['footer']['content'] = str_replace('[idxboost_dinamic_social_network type="footer"]', $variable_idxboost_social_network_dinamic_footer, $result['data']['footer']['content']);
    }
    echo $result['data']['footer']['content'];
}
