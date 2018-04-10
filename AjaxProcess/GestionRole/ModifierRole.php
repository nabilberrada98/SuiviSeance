<?php
require_once '../../classes/Config.php';
require_once '../../classes/Database.php';
require_once '../../Controllers/Controller.php';
require_once '../../Controllers/GestionDesRolesController.php';
$controller=new GestionDesRolesController();
echo $controller->modifierRole($_POST['idRole'],  json_decode($_POST['perms']));
