<?php

require_once '../Entity/UserEntity.php';
require_once '../classes/Database.php';
require_once '../classes/Config.php';
require_once '../Controllers/Controller.php';
require_once '../Controllers/LoginController.php';
require_once '../Views/api/vendor/autoload.php';
if (isset($_GET['code'])) {
    $controller = new LoginController();
    $client = new Google_Client();
    $config = Config::getInstance(dirname(__DIR__) . '\Config\config.php');
    $client->setClientId($config->get('client_id'));
    $client->setClientSecret($config->get('client_secret'));
    $client->setRedirectUri($config->get('redirect_uri'));
    $client->setScopes('email');
    $plus = new Google_Service_Plus($client);
    $client->authenticate($_GET['code']);
    session_start();
    $_SESSION['googleId'] = $client->getAccessToken();
    $me = $plus->people->get('me');
    $conneced = $controller->googleAuth($me['id'], $me['emails'][0]['value'], $me['image']['url'], $me['displayName'], false);
    if ($conneced === "ok") {
        header('Location: ../');
    }else{
         header('Location: ../login?error='.urlencode($conneced));
    }
}