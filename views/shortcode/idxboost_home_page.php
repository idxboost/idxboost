<?php get_header(); ?>

<?php
global $flex_idx_info;


$data = array(
    'registration_key' => get_option('idxboost_registration_key'),
    "page_type" => 'home'
);

$payload = json_encode($data);
// Prepare new cURL resource
$ch = curl_init(IDX_BOOST_SPW_BUILDER_SERVICE . '/api/page-template');
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


$variable = do_shortcode("[idxboost_dinamic_menu]");
$variable_autocomplete = do_shortcode("[flex_autocomplete]");
$idxboost_dinamic_credential_lead_dinamic = do_shortcode('[idxboost_dinamic_credential_lead_dinamic]');
$idxboost_dinamic_menu_mobile = do_shortcode('[idxboost_dinamic_menu_mobile]');

$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Close cURL session handle
curl_close($ch);
if ($httpcode == 200) {
    echo '<div class="flex_ix_home_page">';

    $result['content'] = str_replace("[idxboost_dinamic_menu]", $variable, $result['content']);
    $result['content'] = str_replace("[idxboost_dinamic_menu_mobile]", $idxboost_dinamic_menu_mobile, $result['content']);
    $result['content'] = str_replace("[idxboost_dinamic_autocompleted]", $variable_autocomplete, $result['content']);
    $result['content'] = str_replace('[idxboost_dinamic_credential_lead]', $idxboost_dinamic_credential_lead_dinamic, $result['content']);

    $pattern = '~\[idxboost_dinamic_listings type="property-sites"\]~';
    if (preg_match($pattern, $result['content'], $match)) {
        $variable_idxboost_dinamic_listings = do_shortcode('[list_property_collection column="two" mode="slider"]');
        $result['content'] = str_replace($match[0], $variable_idxboost_dinamic_listings, $result['content']);
    }

    $pattern = '~\[idxboost_dinamic_listings type="exclusive-listings"\]~';
    if (preg_match($pattern, $result['content'], $match)) {
        $variable_idxboost_dinamic_listings = do_shortcode('[flex_idx_filter type="2" mode="slider"]');
        $result['content'] = str_replace($match[0], $variable_idxboost_dinamic_listings, $result['content']);
    }


    $pattern = '~\[flex_idx_filter id="(.+?)" mode="slider"\]~';
    if (preg_match($pattern, $result['content'], $match)) {
        $variable_flex_idx_filter = do_shortcode($match[0]);
        $result['content'] = str_replace($match[0], $variable_flex_idx_filter, $result['content']);
    }

    $pattern = '~\[ib_search_filter id="(.+?)" mode="slider"\]~';
    if (preg_match($pattern, $result['content'], $match)) {
        $ib_search_filter = do_shortcode($match[0]);
        $result['content'] = str_replace($match[0], $ib_search_filter, $result['content']);
    }
    echo $result['content'];
    echo '</div>';
} else {
    status_header(404);
    nocache_headers();
    include(get_query_template('404'));
    die();
}

?>

<?php get_footer(); ?>