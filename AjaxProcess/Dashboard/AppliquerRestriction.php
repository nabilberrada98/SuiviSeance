<?php
require_once '../../classes/Database.php';
require_once '../../classes/Config.php';
require_once '../../Controllers/Controller.php';
require_once '../../Controllers/DashboardController.php';
$controller=new DashboardController();
echo $controller->appliquerRestriction($_POST['fil'],$_POST['dateDebut'],$_POST['dateExp']);