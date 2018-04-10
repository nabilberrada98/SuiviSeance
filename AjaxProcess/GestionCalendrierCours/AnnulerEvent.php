<?php

require_once '../../classes/Database.php';
require_once '../../classes/Config.php';
require_once '../../Controllers/Controller.php';
require_once '../../Controllers/CalendrierController.php';
$controller = new CalendrierController();
$motif = $controller->test_input($_POST['motif']);
$dateAnnulation = $_POST['EventStart'];
$idSeance = $_POST['id'];
$date = DateTime::createFromFormat('Y-m-d H:i:s', $dateAnnulation);
if ($date > new DateTime()) {
    $controller->sendMail($idSeance, date_format($date, 'Y-m-d'), date_format($date, 'H:i'), $motif);
}
echo $controller->AnnulerSeance($idSeance, $motif);
