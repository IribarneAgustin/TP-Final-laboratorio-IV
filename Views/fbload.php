<?php

//session_start();
$fb = new Facebook\Facebook([
'app_id' => '2070276426438697', // Replace {app-id} with your app id
'app_secret' => '0932f4ef5e1651d943eb28cd3c82e7f7',
'default_graph_version' => 'v3.2',
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https:/localhost', $permissions);
echo '<a href="'. htmlspecialchars($loginUrl) . '">Iniciar sesión con Facebook!</a>';
?>
