<?php

require_once '../../classes/Database.php';
require_once '../../classes/Config.php';
require_once '../../Controllers/Controller.php';
require_once '../../Controllers/GestionDesFilieresController.php';
$controller=new GestionDesFilieresController();
echo $controller->modifierFiliere($_POST['id'],$controller->test_input($_POST['nom']),$_POST['dr'],$_POST['rs'],$_POST['email']);
