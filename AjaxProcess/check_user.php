<?php

require_once '../Entity/UserEntity.php';
require_once '../classes/Database.php';
require_once '../classes/Config.php';
require_once '../Controllers/Controller.php';
require_once '../Controllers/LoginController.php';

if (isset($_POST['googleId'])) {
    $googleId = $_POST['googleId']; 
    $saveSes = $_POST['saveSes']; 
    $email = $_POST['email']; 
    $username = $_POST['username']; 
    $imgPath = $_POST['imgPath']; 
    $controller = new LoginController();
    echo $controller->googleAuth($googleId, $email, $imgPath, $username, $saveSes);
} else {
    echo 'error';
}