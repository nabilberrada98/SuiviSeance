<?php

require_once '../../classes/Database.php';
require_once '../../classes/Config.php';
require_once '../../Controllers/Controller.php';
require_once '../../Controllers/GestionDesEtudiantsController.php';
$controller = new GestionDesEtudiantsController();
echo $controller->ajouterEtudiant($_POST['civ'],$_POST['email'] , $_POST['fil']);