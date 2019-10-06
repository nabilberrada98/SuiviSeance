<?php

require_once '../../classes/Database.php';
require_once '../../classes/Config.php';
require_once '../../Controllers/Controller.php';
require_once '../../Controllers/GestionDesMatieresController.php';
$controller=new GestionDesMatieresController();
echo $controller->AddMatiere($controller->test_input($_POST['nom']), $_POST['volume_heure'],$_POST['prixHeure'],$_POST['semestre'],$_POST['prof'],$_POST['metadata']);
