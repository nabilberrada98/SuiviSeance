<?php
require_once '../../classes/Database.php';
require_once '../../classes/Config.php';
require_once '../../Controllers/Controller.php';
require_once '../../Controllers/CalendrierController.php';
require_once '../../Controllers/CalendrierDesCoursController.php';
$controller = new CalendrierDesCoursController();
echo $controller->getDateFin($_POST['semestreParam']);
