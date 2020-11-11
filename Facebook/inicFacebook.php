<?php 
if (!session_id()) {
    session_start();
}
require_once 'autoload.php';

$fb = new Facebook\Facebook([
    'app_id' => '848571982564560',
    'app_secret' => '46e67bc24db949c26f17b9e38a06acdc',
    'default_graph_version' => 'v2.4',
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Generar permisos opcionales
$loginUrl = $helper->getLoginUrl('http://localhost/proyectos/tpfinal/User/callback', $permissions);
?>