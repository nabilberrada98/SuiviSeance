<?php
require_once '../classes/Database.php';
require_once '../classes/Config.php';
require_once '../Controllers/Controller.php';
//require_once '../Controllers/Role.php';
//require_once '../Controllers/PrivilegedUser.php';
//
//$privUser= PrivilegedUser::getByGoogleId('114215323553620452532');
//if ($privUser->hasPrivilege('annuler_seance')) {
//    echo 'il a le privilége';
//}else{
//    echo 'il n a pas le privilége';
//}
$controller = new Controller();
$controller->sendMail(['nabil9852@gmail.com','nabil.berrada684@campus.vinci.ac.ma'], 'Anglais', '2000-01-01', 'absense prrofesseur');