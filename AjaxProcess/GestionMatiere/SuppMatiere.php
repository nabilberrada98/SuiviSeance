<?php
require_once '../../classes/Database.php';
require_once '../../classes/Config.php';
require_once '../../Controllers/Controller.php';
require_once '../../Controllers/GestionDesMatieresController.php';
$idMatiere=$_POST['id'];
$controller = new GestionDesMatieresController();
echo $controller->SupprimerMatiere($idMatiere);