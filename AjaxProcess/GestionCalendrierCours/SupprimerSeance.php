<?php

require_once '../../classes/Database.php';
require_once '../../classes/Config.php';
require_once '../../Controllers/Controller.php';
require_once '../../Controllers/CalendrierController.php';
$controller = new CalendrierController();
echo $controller->SupprimerSeance($_POST['id']);
exit;