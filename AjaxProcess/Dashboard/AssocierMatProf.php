<?php
header('Content-Type: application/json');
require_once '../../classes/Database.php';
require_once '../../classes/Config.php';
require_once '../../Controllers/Controller.php';
require_once '../../Controllers/DashboardController.php';
$controller=new DashboardController();
echo $controller->AssocierProfMatiere($_POST['idMat'],$_POST['idProf']);