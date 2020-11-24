<?php
$params = $_POST;
if ( isset($params['action']) || isset($_POST)) {

$para      = $params['email'];
$titulo    = 'Contact';
$mensaje   = $params['message'];
$cabeceras = 'From: webmaster@dgtalliance.com' . "\r\n" .'Reply-To: webmaster@dgtalliance.com' . "\r\n" .'X-Mailer: PHP/' . phpversion();

$response=mail($para, $titulo, $mensaje, $cabeceras);

echo json_encode( array('message_response' => $response ));
die();
}