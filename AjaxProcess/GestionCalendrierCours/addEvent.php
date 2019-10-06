<?php
require_once '../../classes/Database.php';
require_once '../../classes/Config.php';
require_once '../../Controllers/Controller.php';
require_once '../../Controllers/CalendrierController.php';
require_once '../../Controllers/CalendrierDesCoursController.php';
$controller = new CalendrierDesCoursController();
$date_debut=$_POST['date_debut'];
$date_fin=$_POST['date_fin'];
$nomOccupant=$controller->ProfisBusy($date_debut, $date_fin, $_POST['id_matiere']);
if (is_null($nomOccupant) || $nomOccupant['nom'] == '') {
$etat="standard";
$motif="";
$retard=0;
if ($_POST["annule"] == 'true') {
    $etat="annulé";
    $motif=$controller->test_input($_POST["motif"]);
}else if ($_POST["retard"]=='true') {
    $etat="retard";
    $retard=$controller->test_input($_POST["dureeRetard"]);
}
echo $controller->addSeance($date_debut,$date_fin,$etat,$motif,$_POST['id_matiere'],$_POST['id_salle'],$retard);
}else{
    echo 'Le professeur responsable pour cette matière '.($date_debut>new DateTime()?'sera':'était').' occupé avec la matière '.$nomOccupant['nom'];
}