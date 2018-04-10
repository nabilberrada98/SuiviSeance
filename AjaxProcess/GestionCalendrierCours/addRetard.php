<?php
require_once '../../classes/Database.php';
require_once '../../classes/Config.php';
require_once '../../Controllers/Controller.php';
require_once '../../Controllers/CalendrierController.php';
$controller = new CalendrierController();
echo $controller->addRetard($_POST['id'],$_POST['retard']);