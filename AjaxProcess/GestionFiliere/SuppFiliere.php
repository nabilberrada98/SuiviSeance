<?php

require_once '../../classes/Database.php';
require_once '../../classes/Config.php';
require_once '../../Controllers/Controller.php';
require_once '../../Controllers/GestionDesFilieresController.php';
$controller=new GestionDesFilieresController();
echo $controller->supprimerFiliere($_POST['id']);
