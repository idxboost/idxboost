<?php

$result = [];

if ( 
    ! empty($GLOBALS) && 
    array_key_exists('idx_header_footer', $GLOBALS) && 
    ! empty($GLOBALS['idx_header_footer'])
) {
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
        'Content-Length: ' . strlen($payload)
    ));

    $result = @json_decode(curl_exec($ch), true);
    $GLOBALS['idx_header_footer'] = $result;
    curl_close($ch);
}

$variable = do_shortcode("[idxboost_dinamic_menu]");
$idxboost_dinamic_credential_lead_dinamic = do_shortcode('[idxboost_dinamic_credential_lead_dinamic]');
$idxboost_dinamic_menu_mobile = do_shortcode('[idxboost_dinamic_menu_mobile]');
$template_id = "";

if ( is_array($result) && count($result) > 0 ) {
    $template_id = $result['data']['template_id'];
    
    if (
        array_key_exists('data', $result) && 
        array_key_exists('header', $result['data']) && 
        ! empty($result['data']['header']['content'])
    ) {
        $result['data']['header']['content'] = str_replace("[idxboost_dinamic_menu]", $variable, $result['data']['header']['content']);
        $result['data']['header']['content'] = str_replace("[idxboost_dinamic_menu_mobile]", $idxboost_dinamic_menu_mobile, $result['data']['header']['content']);
        $result['data']['header']['content'] = str_replace("[idxboost_dinamic_credential_lead]", $idxboost_dinamic_credential_lead_dinamic, $result['data']['header']['content']);
        $result['data']['header']['content'] = str_replace("[idxboost_lead_activities]", do_shortcode('[idxboost_lead_activities]'), $result['data']['header']['content']);
    }
    
    echo $result['data']['header']['content'];
}
?>

<script>
    <?php
    $is_compass = strpos($template_id, "compass");
    $is_resf = strpos($template_id, "resf");
    ?>

    document.body.classList.add('ip');
    
    <?php
    if ( 
        ! empty($GLOBALS) && 
        is_array($GLOBALS) &&  
        array_key_exists("crm_theme_setting", $GLOBALS) && 
        is_array($GLOBALS['crm_theme_setting']) && 
        count($GLOBALS['crm_theme_setting']) > 0 
    ) {
        if ( array_key_exists("style", $GLOBALS['crm_theme_setting']) ) {
            echo 'document.body.style = "' . trim($GLOBALS['crm_theme_setting']["style"]) . '";';
            
            if ( 
                array_key_exists("fontFamily", $GLOBALS['crm_theme_setting']) &&
                $GLOBALS['crm_theme_setting']["fontFamily"] == "compass-sans-and-serif"
            ) {
                echo "document.body.classList.add('compass-sans-and-serif');";
            }

            if ( 
                array_key_exists("fontFamily", $GLOBALS['crm_theme_setting']) &&
                $GLOBALS['crm_theme_setting']["fontFamily"] == "dinengschrift-and-open-sans"
            ) {
                echo "document.body.classList.add('dinengschrift-and-open-sans');";
            }
        }
    }

    if ( is_numeric($is_compass) ) {
        echo "document.body.classList.add('ip-theme-compass');";
    } else if ( is_numeric($is_resf) ) {
        echo "document.body.classList.add('ip-theme-resf');";
    }
    ?>
</script>