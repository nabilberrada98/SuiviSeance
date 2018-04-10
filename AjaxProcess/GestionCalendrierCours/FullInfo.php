<?php
header('Content-Type: application/json');
require_once '../../classes/Database.php';
require_once '../../classes/Config.php';
require_once '../../Controllers/Controller.php';
require_once '../../Controllers/CalendrierController.php';
$id=$_POST['id'];
$controller = new CalendrierController();
$event = $controller->EventInfo($id);
echo $event;