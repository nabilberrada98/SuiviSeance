<?php
require_once '../../classes/Database.php';
require_once '../../classes/Config.php';
require_once '../../Controllers/Controller.php';
require_once '../../Controllers/DashboardController.php';
$controller=new DashboardController();
echo $controller->ajouterPaiementHistorique($_POST['somme'],$_POST['duree'],$_POST['id_mat']);