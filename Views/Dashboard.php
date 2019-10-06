<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<?php
if (isset($_SESSION['googleId'])) {
    $googleId = $_SESSION['googleId'];
    $user_name = $_SESSION['user_name'];
    $user_email = $_SESSION['user_email'];
    $user_img_path = $_SESSION['user_img_path'];
    $user_priv = PrivilegedUser::getByGoogleId($googleId);
} else {
    header("Location: login");
}
$roleController = new GestionDesRolesController();
$listUsers = $roleController->getAllUsers();
$etats = 0;
foreach ($listUsers as $us):
    $etats += $us->etat;
endforeach;
$allUsers = count($listUsers);
$blocked = $allUsers - $etats;
$listRoles = $roleController->getAllRoles();
$listPermissions = $roleController->getAllPermissions();
$controller = new DashboardController();
$resFilieres = $controller->getFiliereAvancement();
$listeFilieres = $controller->getAllFilieres();
$historiquePay = $controller->getHistorique();
$listProfMatiere = $controller->getProfMatieres();
$listeProfesseur = $controller->getAllProf();
$listRestrictions = $controller->getAllRestrictions();
?>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="Views/dist/img/logo.png" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= $user_priv->hasPrivilege("Dashboard Admin") ? "Admin" : "Responsable Scolarité" ?> dashboard</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <script src="Views/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="Views/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="Views/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="Views/dist/css/skins/skin-blue.min.css">
        <link href="Views/Full Cal/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        <link href="Views/dist/css/animate.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="Views/plugins/datatables/dataTables.bootstrap.css">
        <link href="Views/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css"/>
        <script src="Views/bootstrap/js/bootstrap.min.js"></script>
        <link href="Views/plugins/iCheck/line/blue.css" rel="stylesheet" type="text/css"/>
        <link href="Views/plugins/ionslider/ion.rangeSlider.css" rel="stylesheet" type="text/css"/>
        <link href="Views/plugins/ionslider/ion.rangeSlider.skinFlat.css" rel="stylesheet" type="text/css"/>
        <script src="Views/plugins/iCheck/icheck.min.js"></script>
        <script src="Views/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
        <script src="Views/plugins/datepicker/locales/bootstrap-datepicker.fr.js" type="text/javascript"></script>
        <script src="Views/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="Views/plugins/datatables/dataTables.bootstrap.min.js"></script>
        <script src="Views/dist/js/bootstrap-confirmation.min.js" type="text/javascript"></script>
        <script src="Views/plugins/ionslider/ion.rangeSlider.min.js" type="text/javascript"></script>
        <script src="Views/dist/js/loadingoverlay.min.js" type="text/javascript"></script>
        <script src="Views/plugins/notify.min.js" type="text/javascript"></script>
        <script src="Views/dist/js/app.min.js"></script>
        <script src="http://code.highcharts.com/highcharts.js"></script>
        <script src="http://code.highcharts.com/modules/drilldown.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="Views/personnalJs/Utils.js" type="text/javascript"></script>
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            #mAddRole th,td ,#mModifierRole th,td {
                padding: 5%;
            }
            .errors{
                border: 0;
                border-bottom: 1px solid red;
                outline: 0;
            }
            .take-all-space-you-can{
                width:33.33%;
            }
            .irs-bar, .irs-line,.irs-slider{
                transform: scaleY(2);
            }
        </style>
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <?php
        if ($user_priv->hasPrivilege("Graphique d'avancement") || $user_priv->hasPrivilege("Dashboard Admin")) {
            ?>
            <?php if ($user_priv->hasPrivilege("Dashboard Admin")) { ?>

                <div class="modal modal-primary fade" id="mAddRole" data-backdrop="false" tabindex="-1" role="dialog" >
                    <div class="modal-dialog  modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Ajouter un Role</h4>
                            </div>
                            <div class="modal-body">
                                <div class="box box-info">
                                    <div class="box-body">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-book"></i> &nbsp; &nbsp; Nom du Role 
                                            </div>
                                            <input type="text" class="form-control" id="roleName">
                                        </div>
                                        <br>
                                        <div class="input-group-addon">
                                            <i class="fa fa-key"></i> &nbsp; &nbsp; Permissions
                                        </div>
                                        <table>
                                            <?php
                                            for ($index = 0; $index < count($listPermissions); $index++) {
                                                echo "<div class='col-md-4' style='margin-top:20px; position : initial;'><input type='checkbox' name='Addpermissions' value='" . $listPermissions[$index]->perm_id . "'><label>" . utf8_encode($listPermissions[$index]->perm_desc) . "</label></div>";
                                            }
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" onclick="AjouterRole()">Sauvegarder</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal modal-primary fade" id="mModifUser" data-backdrop="false" tabindex="-1" role="dialog" >
                    <div class="modal-dialog  modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Modifier l'utilisateur</h4>
                            </div>
                            <div class="modal-body">
                                <div class="box box-info">
                                    <div class="box-body">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-book"></i> &nbsp; &nbsp; Nouveau Role                                            </div>
                                            <select class="form-control roles" id="UserModifRole">
                                                <?php foreach ($listRoles as $role): ?>
                                                    <option  value="<?= $role->role_id ?>"><?= $role->role_name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-book"></i> &nbsp; &nbsp; Nouveau Numéro de téléphone                                            </div>
                                            <input type="text" class="form-control" id="UserModifNumero">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" onclick="ModifierUser($('#UserModifRole').val(), $('#UserModifNumero').val())">Sauvegarder</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal modal-warning fade" id="mModifierRole" data-backdrop="false" tabindex="-1" role="dialog" >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Modifier un Role</h4>
                            </div>
                            <div class="modal-body">
                                <div class="box box-info">
                                    <div class="box-body">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-book"></i> &nbsp; &nbsp; Nom du Role 
                                            </div>
                                            <select class="form-control roles" id="ModifRole" onchange="loadPerms(this.value)">
                                                <?php foreach ($listRoles as $role): ?>
                                                    <option  value="<?= $role->role_id ?>"><?= $role->role_name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <br>
                                        <div class="input-group-addon">
                                            <i class="fa fa-key"></i> &nbsp; &nbsp; Permissions
                                        </div>
                                        <center>
                                            <table>
                                                <?php
                                                for ($index = 0; $index < count($listPermissions); $index++) {
                                                    echo "<div class='col-md-4' style='margin-top : 20px;'><input type='checkbox' name='Modifpermissions' value='" . $listPermissions[$index]->perm_id . "'><label>" . utf8_encode($listPermissions[$index]->perm_desc) . "</label></div>";
                                                }
                                                ?>
                                            </table>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" onclick="ModifierRole()">Sauvegarder</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal modal-primary fade" id="mAddUser" data-backdrop="false" tabindex="-1" role="dialog" >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Ajouter un Utilisateur</h4>
                            </div>
                            <div class="modal-body">
                                <div class="box box-info">
                                    <div class="box-body">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-book"></i> &nbsp; &nbsp; Nom du Role 
                                            </div>
                                            <select class="form-control roles" id="AddUserRole">
                                                <?php foreach ($listRoles as $role): ?>
                                                    <option value="<?= $role->role_id ?>"><?= $role->role_name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-at"></i> &nbsp; &nbsp; Adresse email a autorisé  
                                            </div>
                                            <input type="email" class="form-control" id="AddUserEmail">
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-phone"></i> &nbsp; &nbsp; Numéro de téléphone  
                                            </div>
                                            <input type="tel" class="form-control" id="AddUserTel">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" onclick="AjouterUser()">Sauvegarder</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?> 
            <div class="wrapper">
                <!-- Main Header -->
                <?php require_once 'includes/header.php'; ?>
                <!-- Left side column. contains the logo and sidebar -->
                <?php require_once 'includes/Menu.php'; ?>

                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper" style="min-height: 946px;">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <h2>
                            Dashboard
                        </h2>
                    </section>

                    <!-- Main content -->
                    <section class="content">
                        <div class="row">
                            <?php if ($user_priv->hasPrivilege("Graphique d'avancement")) { ?>
                                <div class="panel-group accordion" id="graph">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background: #eeeeee;color: #000;border-radius: none">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#graph" href="#graphique" aria-expanded="true">
                                                    Graphique d'avancement
                                                </a> <span class="pull-right" style="    margin-top: -4px;">
                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#graph" href="#graphique" aria-expanded="true">
                                                        <i style="margin-top: 4px;padding-left: 8px" class="indicator glyphicon  pull-right glyphicon-chevron-up"></i>
                                                    </a>
                                                </span>
                                            </h4>
                                        </div>
                                        <div id="graphique" class="panel-collapse collapse in" aria-expanded="true" style="">
                                            <div class="panel-body" style="border-top: none">
                                                <div class="col-md-9">
                                                    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                                </div>
                                                <?php if ($user_priv->hasPrivilege("Dashboard Admin")) { ?>
                                                    <div class="col-md-3">
                                                        <div class="small-box bg-aqua">
                                                            <div class="inner">
                                                                <h3><?= $allUsers + 1 ?></h3>
                                                                <p>Total d'utilisateurs</p>
                                                            </div>
                                                            <div class="icon">
                                                                <i class="ion ion-person-stalker"></i>
                                                            </div>
                                                        </div>
                                                        <div class="small-box bg-yellow">
                                                            <div class="inner">
                                                                <h3><?= $blocked ?></h3>
                                                                <p>Utilisateurs désactivés</p>
                                                            </div>
                                                            <div class="icon">
                                                                <i class="ion ion-person"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } if ($user_priv->hasPrivilege("Associer un enseignant a une matière")) { ?>
                                <div class="panel-group accordion" id="MatieresProfesseurs">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background: #eeeeee;color: #000;border-radius: none">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#MatieresProfesseurs" href="#FormProfMatiere" aria-expanded="false">
                                                    Associer les matières aux professeurs 
                                                </a> 
                                                <span class="pull-right" style="margin-top: -4px;">
                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#MatieresProfesseurs" href="#FormProfMatiere" aria-expanded="false">
                                                        <i style="margin-top: 4px;padding-left: 8px" class="indicator glyphicon  pull-right glyphicon-chevron-up"></i>
                                                    </a>
                                                </span>
                                            </h4>
                                        </div>
                                        <div id="FormProfMatiere" class="panel-collapse collapse" aria-expanded="true" style="">
                                            <div class="panel-body" style="border-top: none">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="box box-primary with-border">
                                                            <div class="box-body">
                                                                <div class="form-group">
                                                                    <label>Nom Filière :</label>
                                                                    <select id="AssocierFiliere" class="form-control" onchange="FiliereChanged($(this).val(), $('#AssocierSemestreMatiere'), $('#AssocierNomMatiere'), false)">
                                                                        <?php foreach ($listeFilieres as $fil): ?>
                                                                            <option value="<?= $fil->id ?>"><?= $fil->nom_filiere ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="AssocierSemestreMatiere">Nom Semestre:</label>
                                                                    <select id="AssocierSemestreMatiere" class="form-control" onchange="loadMatieres($('#AssocierNomMatiere'), $(this).val(), false);">
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="AssocierNomMatiere">Nom Matière :</label>
                                                                    <select id="AssocierNomMatiere" class="form-control">
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="AssocierNomProf">Nom Professeur :</label>
                                                                    <select id="AssocierNomProf" class="form-control">
                                                                        <?php foreach ($listeProfesseur as $prof): ?>
                                                                            <option value="<?= $prof->user_id ?>"><?= $prof->user_name ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                <br>
                                                                <button class="btn btn-block btn-primary btn-lg" onclick="AssocierMatierProf($('#AssocierNomMatiere'), $('#AssocierNomProf'))"> Associer la matière au professeur</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <table id="listeProfMatieres" class="table table-condensed table-bordered table-hover dataTable" role="grid" aria-describedby="Liste de professeurs avec leurs matières">
                                                            <thead>
                                                            <th>Nom Filière</th>
                                                            <th>Nom Semestre</th>
                                                            <th>Nom matière</th>
                                                            <th>Nom professeur</th>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $odd = true;
                                                                foreach ($listProfMatiere as $Pm): $odd = !$odd
                                                                    ?>
                                                                    <tr role="row" class="<?php $odd ? "odd" : "even" ?>">
                                                                        <td><?= $Pm->nom_filiere ?></td>
                                                                        <td><?= $Pm->nomSemestre ?></td>
                                                                        <td><?= $Pm->nom ?></td>
                                                                        <td><?= ucwords(strtolower($Pm->user_name)) ?></td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } if ($user_priv->hasPrivilege("Dashboard Admin")) { ?>
                                <div class="panel-group accordion" id="AppliquerRestriction">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background: #eeeeee;color: #000;border-radius: none">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#AppliquerRestriction" href="#FormRestriction" aria-expanded="false">
                                                    Appliquer une restriction
                                                </a> 
                                                <span class="pull-right" style="margin-top: -4px;">
                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#AppliquerRestriction" href="#FormRestriction" aria-expanded="false">
                                                        <i style="margin-top: 4px;padding-left: 8px" class="indicator glyphicon  pull-right glyphicon-chevron-up"></i>
                                                    </a>
                                                </span>
                                            </h4>
                                        </div>
                                        <div id="FormRestriction" class="panel-collapse collapse" aria-expanded="true" style="">
                                            <div class="panel-body" style="border-top: none">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="box box-primary with-border">
                                                            <div class="box-body">
                                                                <div class="form-group">
                                                                    <label>Nom Filière :</label>
                                                                    <select id="RestrictionFiliere" class="form-control">
                                                                        <?php foreach ($listeFilieres as $fil): ?>
                                                                            <option value="<?= $fil->id ?>"><?= $fil->nom_filiere ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                <br>
                                                                <div class="form-group">
                                                                    <label>Date Début Restriction :</label>
                                                                    <input type="text" class="form-control  PickerDate" id="DebutRes">
                                                                </div>
                                                                <br>
                                                                <div class="form-group">
                                                                    <label>Date Expiration Restriction :</label>
                                                                    <input type="text" class="form-control PickerDate" id="ExpRes">
                                                                </div>
                                                                <br>
                                                                <button class="btn btn-block btn-primary btn-lg" onclick="AppliquerRestriction($('#RestrictionFiliere').val(), $('#DebutRes'), $('#ExpRes'))"><i class="fa fa-ban"></i> Appliquer la restriction</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <table id="listeRestriction" class="table table-condensed table-bordered table-hover dataTable" role="grid" aria-describedby="Liste des restrictions">
                                                            <thead>
                                                            <th>Nom Filière</th>
                                                            <th>Date Début restriction</th>
                                                            <th>Date Expiration restriction</th>
                                                            <th>Action</th>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $odd = true;
                                                                foreach ($listRestrictions as $Res): $odd = !$odd
                                                                    ?>
                                                                    <tr role="row" class="<?php $odd ? "odd" : "even" ?>">
                                                                        <td><?= $Res->nom_filiere ?></td>
                                                                        <td><?= $Res->date_debut ?></td>
                                                                        <td><?= $Res->date_expiration ?></td>
                                                                        <td>
                                                                            <button name="supprRes" data-id="<?= $Res->id ?>" class="btn btn-danger" data-btn-ok-label="Oui" data-btn-cancel-label="Non" data-placement="left" data-toggle="confirmation" data-title="Etes vous sure ?"><i class="fa fa-remove"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-group accordion" id="calculRemuneration">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background: #eeeeee;color: #000;border-radius: none">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#calculRemuneration" href="#FormCalcul" aria-expanded="false">
                                                    Calcul de rémunération
                                                </a> <span class="pull-right" style="margin-top: -4px;">
                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#calculRemuneration" href="#FormCalcul" aria-expanded="false">
                                                        <i style="margin-top: 4px;padding-left: 8px" class="indicator glyphicon  pull-right glyphicon-chevron-up"></i>
                                                    </a>
                                                </span>
                                            </h4>
                                        </div>
                                        <div id="FormCalcul" class="panel-collapse collapse" aria-expanded="true" style="">
                                            <div class="panel-body" style="border-top: none">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <label>Nom Filière :</label>
                                                        <select id="CalculRemFiliere" class="form-control" onchange="FiliereChanged($(this).val(), $('#CalculSemestreMatiere'), $('#CalculNomMatiere'), true)">
                                                            <?php foreach ($listeFilieres as $fil): ?>
                                                                <option value="<?= $fil->id ?>"><?= $fil->nom_filiere ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="CalculSemestreMatiere">Nom Semestre:</label>
                                                        <select id="CalculSemestreMatiere" class="form-control" onchange="loadMatieres($('#CalculNomMatiere'), $(this).val(), true);">
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="CalculNomMatiere">Nom Matière :</label>
                                                        <select id="CalculNomMatiere" class="form-control">
                                                        </select>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label for="CalculNomMatiere">Volume d'heures réalisé :</label>
                                                                <div class="range-slider">
                                                                    <input id="VolumeAPaye" type="text" class="js-range-slider" value="" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <br>
                                                            <br>
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-money"></i> &nbsp; &nbsp; Prix Total en DH
                                                                </div>
                                                                <input type="number" class="form-control" id="PrixTotalRenum">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <button class="btn btn-block btn-primary btn-lg" onclick="EnregistrerPayement($('#PrixTotalRenum').val())"><i class="fa fa-money "></i> &nbsp; Enregistrer comme payé &nbsp; <i class="fa fa-money "></i></button>
                                                    <br>
                                                    <div class="row">
                                                        <div class="box box-primary">
                                                            <div class="box-header with-border">
                                                                <h3 class="box-title">Historique paiements </h3>
                                                            </div>
                                                            <div class="box-body">
                                                                <table id="historiquePaiement" class="table table-condensed table-bordered table-hover dataTable" role="grid">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th >Nom Matière</th>
                                                                            <th >Date de paiement</th>
                                                                            <th>Somme Payé</th>
                                                                            <th>Volume d'heure payé</th>
                                                                            <th >Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach ($historiquePay as $hp): ?>
                                                                            <tr role="row" class="odd">
                                                                                <td><?= $hp->nom ?></td>
                                                                                <td><?= $hp->date_paiement ?></td>
                                                                                <td ><?= $hp->somme_paye ?></td>
                                                                                <td><?= $controller->convertToHoursMins($hp->duree_minutes) ?></td>
                                                                                <td>
                                                                                    &nbsp;<button name="supprHistorique" data-id="<?= $hp->id ?>" class="btn btn-danger" data-btn-ok-label="Oui" data-btn-cancel-label="Non" data-placement="left" data-toggle="confirmation" data-title="Etes vous sure ?"><i class="fa fa-remove"></i></button>
                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-group accordion" id="roles">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background: #eeeeee;color: #000;border-radius: none">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#roles" href="#userRoles" aria-expanded="false">
                                                    Gestion des  rôles & Utilisateurs
                                                </a> <span class="pull-right" style="margin-top: -4px;">
                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#roles" href="#userRoles" aria-expanded="false">
                                                        <i style="margin-top: 4px;padding-left: 8px" class="indicator glyphicon  pull-right glyphicon-chevron-up"></i>
                                                    </a>
                                                </span>
                                            </h4>
                                        </div>
                                        <div id="userRoles" class="panel-collapse collapse" aria-expanded="true" style="">
                                            <div class="panel-body" style="border-top: none">
                                                <div class="panel panel-info col-md-6">
                                                    <div class="panel-heading"><i class="fa fa-key"></i>&nbsp; Gestion des rôles</div>
                                                    <div class="panel-body">
                                                        <Center>
                                                            <div class="btn-group" role="group" >
                                                                <button type="button" class="btn btn-primary btn-lg fa fa-plus" data-toggle="modal" data-target="#mAddRole">
                                                                    Ajouter rôle
                                                                </button>
                                                                <button type="button" class="btn btn-warning btn-lg fa fa-edit" data-toggle="modal" data-target="#mModifierRole" onclick="loadPerms($('#ModifRole').val())">
                                                                    Modifier rôle
                                                                </button>
                                                                <!--                                                        <button type="button" class="btn btn-danger btn-flat fa fa-trash" data-toggle="modal" data-target="#mSupprimerRole">
                                                                                                                            Supprimer rôle
                                                                                                                        </button>-->
                                                            </div>
                                                        </Center>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <center> <i class="fa fa-lock" style="font-size : 75px; color: #4cc0f7"></i></center>
                                                </div>
                                                <div class="panel panel-info col-md-5">
                                                    <div class="panel-heading"><i class="fa fa-user"></i>&nbsp;Gestion des utilisateurs</div>
                                                    <div class="panel-body">
                                                        <button type="button" class="btn btn-primary btn-lg fa fa-plus" data-toggle="modal" data-target="#mAddUser">
                                                            Ajouter Utilisateur
                                                        </button>
                                                    </div>
                                                </div>
                                                <table id="listeusers" class="table table-condensed table-bordered table-hover dataTable" role="grid" aria-describedby="Liste Utilisateurs">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting_asc" tabindex="0" aria-controls="listeusers" rowspan="1" colspan="1" aria-label="Cliquez pour changer d'ordre">Civilité</th>
                                                            <th class="sorting" tabindex="0" aria-controls="listeusers" rowspan="1" colspan="1" aria-label="Cliquez pour changer d'ordre" aria-sort="ascending">Adresse mail</th>
                                                            <th class="sorting" tabindex="0" aria-controls="listeusers" rowspan="1" colspan="1" aria-label="Cliquez pour changer d'ordre">Numéro de téléphone</th>
                                                            <th class="sorting" tabindex="0" aria-controls="listeusers" rowspan="1" colspan="1" aria-label="Cliquez pour changer d'ordre">Role</th>
                                                            <th class="sorting" tabindex="0" aria-controls="listeusers" rowspan="1" colspan="1" aria-label="Cliquez pour changer d'ordre">Etat</th>
                                                            <th class="sorting" tabindex="0" aria-controls="listeusers" rowspan="1" colspan="1" aria-label="Cliquez pour changer d'ordre">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($listUsers as $user): ?>
                                                            <tr role="row" class="odd">
                                                                <td class=""><img src="<?= is_null($user->user_img_path) ? "Views/dist/img/users.png" : $user->user_img_path ?>" class="img-circle" style="width: 25px;"/> &nbsp;&nbsp; <?= ucwords(strtolower($user->user_name)) ?></td>
                                                                <td class="sorting_1"><?= $user->user_email ?></td>
                                                                <td><?= $user->user_phone ?></td>
                                                                <td><?= $user->role_name ?></td>
                                                                <td><i name='infoEtat' id="<?= $user->user_id ?>" class="<?= $user->etat == 1 ? "text-primary" : "text-danger" ?>"><?= $user->etat == 1 ? "Activé" : "Désactivé" ?></i></td>
                                                                <td>
                                                                    <button id="<?= $user->user_id ?>" onclick="showConfig($(this).attr('id'))" class="btn btn-primary"><i class="fa fa-cogs"></i></button>
                                                                    &nbsp;<button name="suppr" data-id="<?= $user->user_id ?>" class="btn btn-danger" data-btn-ok-label="Oui" data-btn-cancel-label="Non" data-placement="left" data-toggle="confirmation" data-title="Etes vous sure ?"><i class="fa fa-remove"></i></button>
                                                                    &nbsp;<button name="block" id='<?= $user->user_id ?>' etat="<?= $user->etat ?>" class="btn btn-warning fa <?= $user->etat == 1 ? "fa-ban" : "fa-unlock" ?>" data-btn-ok-label="Oui" data-btn-cancel-label="Non" data-placement="left" data-toggle="confirmation" data-title="Voulez vous vraiment changé l'état de cette utilisateur ?"></button>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?> 
                        </div>
                    </section>
                    <!-- /.content -->
                </div>
                <!-- /.content-wrapper -->

                <!-- Main Footer -->
                <?php include 'includes/footer.php'; ?>
            </div>


            <!-- Optionally, you can add Slimscroll and FastClick plugins.
                     Both of these plugins are recommended to enhance the
                    user experience.Slimscroll is required when using the
                    fixed layout. -->                            
            <script>
                var prix_heure;
                function AssocierMatierProf(mat, prof) {
                    if (mat.val() == null || mat.val() == '') {
                        mat.addClass('errors');
                    } else {
                        if (prof.val() == null || prof.val() == '') {
                            prof.addClass('errors');
                        } else {
                            $.post("AjaxProcess/Dashboard/AssocierMatProf.php", {idMat: mat.val(), idProf: prof.val()}, function (data, status) {
                                if (parseInt(data) >= 1) {
                                    location.reload();
                                } else {
                                    displayNotification(data, "danger");
                                }
                            });
                        }
                    }
                }

                function loadMatieres(matiere, semestre, isCalcule) {
                    matiere.empty();
                    $.post("AjaxProcess/GestionCalendrierCours/GetSemestreMatieres.php", {semestreParam: semestre}, function (data, status) {
                        data.forEach(function (obj) {
                            matiere.append("<option value='" + obj.id + "'>" + obj.nom + "</option>");
                        });
                    });
                    if (isCalcule) {
                        $(".range-slider").hide(100);
                    }
                }

                function FiliereChanged(fil, semestre, matiere, isCalcule) {
                    $.post("AjaxProcess/GestionCalendrierCours/GetFiliereSemestres.php", {filiereParam: fil}, function (data, status) {
                        semestre.empty();
                        data.forEach(function (obj) {
                            semestre.append("<option value='" + obj.id + "'>" + obj.nomSemestre + "</option>");
                        });
                        loadMatieres(matiere, semestre.val(), isCalcule);
                    });
                }

                $(document).ready(function () {
                    $('#listeProfMatieres').DataTable(DataTableParams);
                    $('#container').highcharts({
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Etat d\'avancement filières/matières'
                        },
                        xAxis: {
                            type: 'category'
                        },
                        tooltip: {
                            pointFormat: '<span style="color:{series.color}"></span>:({point.y}%)<br/>',
                            shared: true
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Pourcentage d\'accomplissement'
                            }, labels: {
                                format: '{value} %'
                            }
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{y} %'
                                }
                            }
                        },
                        series: [<?=$controller->getFilieres()?>],
                        drilldown: {
                            series: [ 
                                <?=$controller->getChartSemestresData()?>
                                                    ,
                                <?=$controller->getChartMatieresData()?>
                                ]
                        }
                    });
                    FiliereChanged($('#CalculRemFiliere').val(), $('#CalculSemestreMatiere'), $('#CalculNomMatiere'), true);
                    FiliereChanged($('#AssocierFiliere').val(), $('#AssocierSemestreMatiere'), $('#AssocierNomMatiere'), false);
                });
                $(document).ajaxStart(function () {
                    $.LoadingOverlay("show", {
                        image: "",
                        fontawesome: "fa fa-hourglass-start fa-spin"
                    });
                });
                $(document).ajaxStop(function () {
                    $.LoadingOverlay("hide");
                });
    <?php if ($user_priv->hasPrivilege("Dashboard Admin")) { ?>
                    var SelectedUser;
                    $(document).ready(function () {
                        $(".PickerDate").datepicker({
                            format: 'yyyy-mm-dd',
                            language: 'fr'
                        });
                        $('#DebutRes').datepicker().on('changeDate', function (ev) {
                            $('#ExpRes').datepicker('setStartDate', ev.date);
                        });
                        $('#listeRestriction').DataTable(DataTableParams);
                        $('#listeusers').DataTable(DataTableParams);
                        $("#historiquePaiement").DataTable(DataTableParams);
                        $('#VolumeAPaye').ionRangeSlider({
                            type: "single",
                            min: 0,
                            max: 0,
                            from: 15,
                            step: 15,
                            onChange: function (data) {
                                $("#PrixTotalRenum").val((data.from / 60) * prix_heure);
                            },
                            prettify: function (val) {
                                return convertToHoursMins(val);
                            }
                        });
                        $(".range-slider").hide();
                        $('input').each(function () {
                            var self = $(this),
                                    label = self.next(),
                                    label_text = label.text();
                            label.remove();
                            self.iCheck({
                                checkboxClass: 'icheckbox_line-blue',
                                insert: '<div class="icheck_line-icon"></div>' + label_text
                            });
                        });
                    });
                    function AppliquerRestriction(fil, dateDeb, DateExp) {
                        dateDeb.removeClass('errors');
                        DateExp.removeClass('errors');
                        if (dateDeb.val() == null || dateDeb.val() == '') {
                            dateDeb.addClass('errors');
                        } else if (DateExp.val() == null || DateExp.val() == '') {
                            DateExp.addClass('errors');
                        } else {
                            $.post("AjaxProcess/Dashboard/AppliquerRestriction.php", {fil: fil, dateDebut: dateDeb.val(), dateExp: DateExp.val()}, function (data, status) {
                                if (!isNaN(data)) {
                                    location.reload();
                                } else {
                                    displayNotification("Restriction non Appliqué", "danger");
                                }
                            });
                        }
                    }

                    $('#CalculNomMatiere').on('change', function () {
                        $.post("AjaxProcess/Dashboard/MatiereInfos.php", {idMat: $(this).val()}, function (data, status) {
                            if (data != null) {
                                console.log(data.paye);
                                $("#VolumeAPaye").data("ionRangeSlider").update({
                                    max: data.paye
                                });
                                $(".range-slider").show(100);
                            }
                            prix_heure = data.prix_par_heure;
                        });
                    }).click(function () {
                        if ($('#CalculNomMatiere option').length == 1) {
                            $('#CalculNomMatiere').change();
                        }
                    });
                    function EnregistrerPayement() {
                        var x = confirm("Etes vous sure de vouloir enregistrer le paiement ?");
                        if (x) {
                            var pr = $("#PrixTotalRenum");
                            var matiere = $('#CalculNomMatiere');
                            if (pr.val() != '' && pr.val() != null) {
                                if (matiere.val() != '' && matiere.val() != null) {
                                    $.post("AjaxProcess/Dashboard/EnregistrerPaiement.php", {somme: pr.val(), duree: $('#VolumeAPaye').val(), id_mat: matiere.val()}, function (data, status) {
                                        if (!isNaN(parseInt(data))) {
                                            location.reload();
                                        } else {
                                            displayNotification('Paiement non ajouté a l\'historique , ' + data, "error");
                                        }
                                    });
                                } else {
                                    displayNotification("veuillez renseigner le champ prix nom matière.", "danger");
                                    matiere.addClass("errors");
                                }
                            } else {
                                displayNotification("veuillez renseigner le champ prix Total.", "danger");
                                pr.addClass("errors");
                            }
                        }
                    }

                    function AjouterUser() {
                        $("#AddUserEmail").removeClass("errors");
                        var usMail = $("#AddUserEmail").val();
                        var usTel = $("#AddUserTel").val();
                        if (validateEmail(usMail)) {
                            $.post("AjaxProcess/GestionRole/AjouterUser.php", {email: usMail, role: $("#AddUserRole").val(), tel: usTel}, function (data, status) {
                                if (!isNaN(parseInt(data))) {
                                    location.reload();
                                } else {
                                    displayNotification('Adresse email existante ! , ' + data, "error");
                                }
                            });
                        } else {
                            $("#AddUserEmail").addClass("errors");
                        }
                    }

                    function loadPerms(role) {
                        $("input:checkbox[name=Modifpermissions]").each(function () {
                            $(this).iCheck('uncheck');
                        });
                        $.post("AjaxProcess/GestionRole/getPerms.php", {id: role}, function (data, status) {
                            var perms = JSON.parse(data);
                            if (perms.constructor === Array) {
                                for (var i = 0; i < perms.length; i++) {
                                    $("input:checkbox[name=Modifpermissions][value=" + perms[i].perm_id + "]").iCheck('check');
                                }
                            } else {
                                $("input:checkbox[name=Modifpermissions][value='" + data.perm_id + "']").iCheck('check');
                            }
                        });
                        //                                                 $("#mModifierRole").show();
                    }

                    function showConfig(id) {
                        SelectedUser = id;
                        $('#mModifUser').modal('show');
                    }

                    function ModifierUser(role, num) {
                        $.post("AjaxProcess/GestionRole/ModifierUser.php", {id: SelectedUser, role: role, numTelef: num}, function (data, status) {
                            if (parseInt(data) >= 1) {
                                location.reload();
                            } else {
                                displayNotification("Erreur de modification , " + data, "danger");
                            }
                        });
                    }

                    function AjouterRole() {
                        $("#roleName").removeClass("errors");
                        if ($("#roleName").val() != null && $("#roleName").val() != '') {
                            var array = [];
                            $("input:checkbox[name=Addpermissions]:checked").each(function () {
                                array.push($(this).val());
                                $(this).prop('checked', false);
                            });
                            $.post("AjaxProcess/GestionRole/AjouterRole.php", {perms: JSON.stringify(array), nomRole: $("#roleName").val()}, function (data, status) {
                                if (data != null || data != '') {
                                    $(".roles").append('<option value="' + data + '">' + $("#roleName").val() + '</option>');
                                    $("#mAddRole").hide();
                                    displayNotification("Role ajouté avec succés", "success");
                                } else {
                                    displayNotification(data, "danger");
                                }
                            });
                        } else {
                            $("#roleName").addClass("errors");
                        }
                    }

                    function ModifierRole() {
                        var array = [];
                        $("input:checkbox[name=Modifpermissions]:checked").each(function () {
                            array.push($(this).val());
                        });
                        $.post("AjaxProcess/GestionRole/ModifierRole.php", {idRole: $("#ModifRole").val(), perms: JSON.stringify(array)}, function (data, status) {
                            if (parseInt(data) >= 1) {
                                $("#mModifierRole").hide();
                                displayNotification("Role modifié avec succés", "success");
                            } else {
                                displayNotification(data, "danger");
                            }
                        });
                    }

                    $('[data-toggle=confirmation][name=\'block\']').confirmation({
                        rootSelector: '[data-toggle=confirmation]',
                        container: 'body',
                        onConfirm: function (event, element) {
                            var idUser = this.attr('id');
                            var etat = parseInt(this.attr('etat')) === 1 ? 0 : 1;
                            $.post("AjaxProcess/GestionRole/LockUser.php", {id: idUser, Nvetat: etat}, function (data, status) {
                                if (parseInt(data) >= 1) {
                                    var element = $("[name=\'block\'][id='" + idUser + "']");
                                    var info = $("[name=infoEtat][id='" + idUser + "']");
                                    if (etat === 1) {
                                        element.removeClass("fa-unlock");
                                        element.addClass("fa-ban");
                                        info.removeClass("text-danger");
                                        info.addClass("text-primary");
                                        info.text("Activé");
                                        displayNotification("Utilisateur activé avec succées", "success");
                                    } else {
                                        element.addClass("fa-unlock");
                                        element.removeClass("fa-ban");
                                        info.removeClass("text-primary");
                                        info.addClass("text-danger");
                                        info.text("Désactivé");
                                        displayNotification("Utilisateur desactivé avec succées", "success");
                                    }
                                } else {
                                    displayNotification(data, "danger");
                                }
                            });
                            this.attr('etat', etat);
                        }
                    });
                    $('[data-toggle=confirmation][name=\'supprRes\']').confirmation({
                        rootSelector: '[data-toggle=confirmation]',
                        container: 'body',
                        onConfirm: function (event, element) {
                            var idRest = this.data('id');
                            var row = this.parents('tr');
                            $.post("AjaxProcess/Dashboard/SupprimerRestriction.php", {id: idRest}, function (data, status) {
                                if (parseInt(data) >= 1) {
                                    var t = $('#listeRestriction').DataTable();
                                    t.row(row).remove().draw();
                                    displayNotification("Supprimé avec succées", "success");
                                } else {
                                    displayNotification(data, "danger");
                                }
                            });
                        }
                    });
                    $('[data-toggle=confirmation][name=\'supprHistorique\']').confirmation({
                        rootSelector: '[data-toggle=confirmation]',
                        container: 'body',
                        onConfirm: function (event, element) {
                            var idHisto = this.data('id');
                            var row = this.parents('tr');
                            console.log("histo suppr");
                            $.post("AjaxProcess/Dashboard/SupprimerHistorique.php", {id: idHisto}, function (data, status) {
                                if (parseInt(data) >= 1) {
                                    var t = $('#historiquePaiement').DataTable();
                                    t.row(row).remove().draw();
                                    displayNotification("Supprimé avec succées", "success");
                                } else {
                                    displayNotification(data, "danger");
                                }
                            });
                        }
                    });
                    $('[data-toggle=confirmation][name=\'suppr\']').confirmation({
                        rootSelector: '[data-toggle=confirmation]',
                        container: 'body',
                        onConfirm: function (event, element) {
                            var idUser = this.data('id');
                            var row = this.parents('tr');
                            console.log("user suppr");
                            $.post("SupprimerUser", {id: idUser}, function (data, status) {
                                if (parseInt(data) >= 1) {
                                    var t = $('#listeusers').DataTable();
                                    t.row(row).remove().draw();
                                    displayNotification("Utilisateur supprimé avec succées", "success");
                                } else {
                                    displayNotification(data, "danger");
                                }
                            });
                        }
                    });
    <?php } ?>

            </script>
            <?php
        } else {
            include 'includes/AccessDenied.php';
        }
        
        ?>
    </body>
</html>
