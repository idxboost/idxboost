<?php

set_time_limit(0);
ignore_user_abort(true);

if (!defined('ABSPATH')) {
    define('WP_USE_THEMES', false);
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php';
}

$access_token     = flex_idx_get_access_token();

$lead_credentials = null;

if (isset($_COOKIE["ib_lead_token"])) {
    $lead_credentials = $_COOKIE["ib_lead_token"];
} else {
    $lead_credentials = $_REQUEST["ib_lead_token"];
}

$socket_id        = isset($_POST['socket_id']) ? $_POST['socket_id'] : null;
$channel_name     = isset($_POST['channel_name']) ? $_POST['channel_name'] : null;

$ch = curl_init();

$ip_address = get_client_ip_server();
$origin     = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';

$sendParams = array(
    'access_token'     => $access_token,
    'lead_credentials' => $lead_credentials,
    'socket_id'        => $socket_id,
    'channel_name'     => $channel_name,
    'ip_address' => $ip_address,
    'origin' => $origin,
    'user_agent' => $user_agent
);

curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_LEADS_STATUS);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);
curl_close($ch);

$response = json_decode($server_output, true);
wp_send_json($response);
exit;