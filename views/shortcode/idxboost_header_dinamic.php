<?php

$result = idxboost_cms_get_header_footer();

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
        echo $result['data']['header']['content'];
    }
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
        }
    }

    if ( is_numeric($is_compass) ) {
        echo "document.body.classList.add('ip-theme-compass');";
    } else if ( is_numeric($is_resf) ) {
        echo "document.body.classList.add('ip-theme-resf');";
    }
    ?>
</script>