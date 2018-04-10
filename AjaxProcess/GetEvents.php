<?php
header('Content-Type: application/json');
require_once '../Entity/SeanceEntity.php';
require_once '../classes/Database.php';
require_once '../classes/Config.php';
require_once '../Controllers/Controller.php';
require_once '../Controllers/CalendrierController.php';
$semestre=$_GET['semestreParam'];
$typeSeance=$_GET['type'];
$controller = new CalendrierController();
$events = $controller->getEvents($semestre,$typeSeance);
echo $events;
exit;
?>
