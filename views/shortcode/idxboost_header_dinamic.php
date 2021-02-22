<?php
$result = [];
if (!empty($GLOBALS) && array_key_exists('idx_header_footer', $GLOBALS) && !empty($GLOBALS['idx_header_footer'])) {
    $result = $GLOBALS['idx_header_footer'];
} else {

    global $flex_idx_info;


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
$variable_idxboost_social_network_dinamic_header = do_shortcode('[idxboost_social_network_dinamic_header]');
$idxboost_dinamic_credential_lead_dinamic = do_shortcode('[idxboost_dinamic_credential_lead_dinamic]');
$idxboost_dinamic_menu_mobile = do_shortcode('[idxboost_dinamic_menu_mobile]');

$template_id = "";
if (is_array($result) && count($result) > 0) {
    $template_id = $result['data']['template_id'];
    if (array_key_exists('data', $result) && array_key_exists('header', $result['data']) && !empty($result['data']['header']['content'])) {
        $result['data']['header']['content'] = str_replace("[idxboost_dinamic_menu]", $variable, $result['data']['header']['content']);
        $result['data']['header']['content'] = str_replace("[idxboost_dinamic_menu_mobile]", $idxboost_dinamic_menu_mobile, $result['data']['header']['content']);
        $result['data']['header']['content'] = str_replace('[idxboost_dinamic_social_network type="header"]', $variable_idxboost_social_network_dinamic_header, $result['data']['header']['content']);
        $result['data']['header']['content'] = str_replace('[idxboost_dinamic_credential_lead]', $idxboost_dinamic_credential_lead_dinamic, $result['data']['header']['content']);
    }
    echo $result['data']['header']['content'];
}
?>

<script>
    <?php
    $is_compass = strpos($template_id, "compass");
    ?>

    document.body.classList.add('ip');
    <?php  if (is_numeric($is_compass)) {
        echo "document.body.classList.add('ip-theme-compass');";
    }  ?>
</script>