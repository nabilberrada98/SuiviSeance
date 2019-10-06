<?php
header('Content-Type: application/json');
require_once '../../classes/Database.php';
require_once '../../classes/Config.php';
require_once '../../Controllers/Controller.php';
require_once '../../Controllers/CalendrierController.php';
require_once '../../Controllers/CalendrierDesCoursController.php';
$id=$_POST['idFilere'];
$controller = new CalendrierDesCoursController();
echo json_encode($controller->getRestriction($id));