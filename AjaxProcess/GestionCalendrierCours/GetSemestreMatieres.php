<?php
header('Content-Type: application/json');
require_once '../../Entity/MatiereEntity.php';
require_once '../../classes/Database.php';
require_once '../../classes/Config.php';
require_once '../../Controllers/Controller.php';
require_once '../../Controllers/CalendrierController.php';
$semestre=$_POST['semestreParam'];
$controller = new CalendrierController();
$matieres = $controller->getAllMatieres($semestre);
echo json_encode($matieres);
exit;
?>
