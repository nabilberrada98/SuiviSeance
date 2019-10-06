<?php

require_once '../classes/Database.php';
require_once '../classes/Config.php';
require_once '../Controllers/Controller.php';
require_once '../Controllers/DashboardController.php';
const keys = array('name', 'y', 'drilldown');
function getFilieres() {
    $controller = new DashboardController();
    $filieres = $controller->getFiliereAvancement();
    $objSem = [];
    foreach ($filieres as $fil):
        array_push($objSem, array_combine(keys, $fil));
    endforeach;
    foreach ($objSem as $obj):
        settype($obj['y'],"double");
    endforeach;
    $res = array();
    $res['name'] = 'filières';
    
    $res['colorByPoint'] = true;
    $res['data'] = $objSem;
    return json_encode($res);
}

function getSemestresFiliere($idFil) {
    $keys = array('name', 'y', 'drilldown');
    $controller = new DashboardController();
    $semestres = $controller->getSemestreAvancement($idFil);
    $objSem = [];
    foreach ($semestres as $sem):
        array_push($objSem, array_combine($keys, $sem));
    endforeach;
    foreach ($objSem as $obj):
        settype($obj['y'],"double");
    endforeach;
    $res = array();
    $res['id'] = $idFil;
    $res['data'] = $objSem;
    return json_encode($res);
}

function getMatieresSemestre($idSem) {
    $keys = array('name', 'y');
    $controller = new DashboardController();
    $matieres = $controller->getMatieresAvancement($idSem);
    $objSem = [];
    foreach ($matieres as $mat):
        array_push($objSem, array_combine($keys, $mat));
    endforeach;
    $res = array();
    $res['id'] = $idSem . 'S';
    $res['data'] = $objSem;
    return json_encode($res);
}
echo getFilieres();
