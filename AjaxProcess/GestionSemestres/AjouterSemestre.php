<?php
require_once '../../classes/Database.php';
require_once '../../classes/Config.php';
require_once '../../Controllers/Controller.php';
require_once '../../Controllers/GestionDesSemestresController.php';
$controller = new GestionDesSemestresController();
echo $controller->ajouterSemestre($_POST['filiere'],$_POST['nomSemestre'],$_POST['debutS'],$_POST['finS']);

