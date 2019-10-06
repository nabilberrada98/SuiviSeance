<?php
header('Content-Type: application/json');
require_once '../../classes/Database.php';
require_once '../../classes/Config.php';
require_once '../../Controllers/Controller.php';
require_once '../../Controllers/GestionDesMatieresController.php';
$controller=new GestionDesMatieresController();
echo json_encode($controller->getInfos(4));