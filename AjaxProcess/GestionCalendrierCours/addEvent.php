<?php
require_once '../../classes/Database.php';
require_once '../../classes/Config.php';
require_once '../../Controllers/Controller.php';
require_once '../../Controllers/CalendrierController.php';
$controller = new CalendrierController();
$etat="standard";
$motif="";
if ($_POST["etat"] == 'true') {
    $etat="annulé";
    $motif=$controller->test_input($_POST["motif"]);
}
echo $controller->addSeance($_POST['date_debut'],$_POST['date_fin'],$_POST['type'],$etat,$motif,$_POST['metadata'],$_POST['id_matiere'],$_POST['id_salle']);