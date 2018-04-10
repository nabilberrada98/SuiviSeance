<?php
require_once '../Entity/UserEntity.php';
require_once '../classes/Database.php';
require_once '../classes/Config.php';
require_once '../Controllers/Controller.php';
require_once '../Controllers/LoginController.php';

if (isset($_POST['emailParam']) && !empty($_POST['emailParam'])) {
    if (isset($_POST['passParam']) && !empty($_POST['passParam'])) {
        $controller = new LoginController();
        echo $controller->login($_POST['emailParam'], $_POST['passParam'], $_POST['remember']);
        $controller=null;
    } else {
        echo 'pass';
    }
} else {
    echo 'login';
}

