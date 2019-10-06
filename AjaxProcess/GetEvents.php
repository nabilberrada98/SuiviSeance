<?php
header('Content-Type: application/json');
require_once '../Entity/SeanceEntity.php';
require_once '../classes/Database.php';
require_once '../classes/Config.php';
require_once '../Controllers/Controller.php';
require_once '../Controllers/CalendrierController.php';
require_once '../Controllers/CalendrierDesCoursController.php';
$semestre=$_GET['semestreParam'];
$controller = new CalendrierDesCoursController();
$events = $controller->getEvents($semestre);
echo $events;
exit;
?>
