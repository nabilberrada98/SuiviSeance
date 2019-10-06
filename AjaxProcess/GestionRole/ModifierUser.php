<?php
require_once '../../classes/Database.php';
require_once '../../classes/Config.php';
require_once '../../Controllers/Controller.php';
require_once '../../Controllers/GestionDesRolesController.php';
$controller=new GestionDesRolesController();
echo $controller->UpdateUser($_POST['id'],$_POST['role'],$controller->test_input($_POST['numTelef']));
