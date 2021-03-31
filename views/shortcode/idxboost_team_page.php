<?php
global $flex_idx_info;

$data = array(
    'registration_key' => get_option('idxboost_registration_key')
);

$payload = json_encode($data);
// Prepare new cURL resource
$ch = curl_init(IDX_BOOST_SPW_BUILDER_SERVICE_TEAM_PAGE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLINFO_HEADER_OUT, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

// Set HTTP Header for POST request
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($payload))
);

// Submit the POST request
$result = curl_exec($ch);

$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Close cURL session handle
curl_close($ch);
if ($httpcode == 200) {
    $jsonObj = json_decode($result);
    if ($jsonObj->content != null) {
        echo '<div class="flex_ix_team_page">';
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
?>