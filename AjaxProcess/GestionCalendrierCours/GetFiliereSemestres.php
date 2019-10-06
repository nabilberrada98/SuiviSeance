<?php
header('Content-Type: application/json');
require_once '../../classes/Database.php';
require_once '../../classes/Config.php';
require_once '../../Controllers/Controller.php';
require_once '../../Controllers/CalendrierController.php';
require_once '../../Controllers/CalendrierDesCoursController.php';
$filiere=$_POST['filiereParam'];
$controller = new CalendrierDesCoursController();
$semestres= $controller->getAllSemestres($filiere);
echo json_encode($semestres);
exit;
?>
