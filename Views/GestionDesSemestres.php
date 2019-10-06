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
$controller = new GestionDesSemestresController();
$listeSemestres = $controller->getAllSemestres();
$listeFilieres = $controller->getAllFilieres();
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <link rel="icon" type="image/png" href="Views/dist/img/logo.png" />
        <title>Gestion Semestres | SuiviSeance</title>
        <script src="Views/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link href="Views/Full Cal/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="Views/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="Views/dist/css/AdminLTE.min.css">
        <link href="Views/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="Views/dist/css/skins/skin-blue.min.css">
        <link href="Views/plugins/datatables/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
        <script src="Views/bootstrap/js/bootstrap.min.js"></script>
        <script src="Views/plugins/notify.min.js" type="text/javascript"></script>
        <script src="Views/dist/js/app.min.js"></script>
        <script src="Views/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
        <script src="Views/plugins/datepicker/locales/bootstrap-datepicker.fr.js" type="text/javascript"></script>
        <script src="Views/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="Views/plugins/datatables/dataTables.bootstrap.min.js"></script>
        <script src="Views/dist/js/bootstrap-confirmation.min.js" type="text/javascript"></script>
        <script src="Views/personnalJs/Utils.js" type="text/javascript"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            .take-all-space-you-can{
                width: 50%;
            }
        </style>
    </head>
    <body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
        <script>
            jQuery('body').css('display', 'none');
            jQuery(document).ready(function () {
                jQuery('body').fadeIn();
            });
            setTimeout(function () {
                jQuery('body').fadeIn();
            }, 1000);
        </script>
        <?php
        if ($user_priv->hasPrivilege("Gestion Semestres")) {
            ?>
            <div class="wrapper">
                <!-- Main Header -->
                <?php require_once 'includes/header.php'; ?>
                <!-- Left side column. contains the logo and sidebar -->
                <?php require_once 'includes/Menu.php'; ?>
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <section class="content">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Gestion des semestres </h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="panel with-nav-tabs panel-default">
                                            <div class="panel-heading">
                                                <ul class="nav nav-tabs">
                                                    <li class="take-all-space-you-can active"><a href="#tab1primary" data-toggle="tab"><Center><i class="fa fa-plus-circle"></i>&nbsp; Ajouter Semestre &nbsp;</Center></a></li>
                                                    <li class="take-all-space-you-can"><a href="#tab2primary" data-toggle="tab"><Center><i class="fa fa-edit"></i>&nbsp; Modifier Semestre&nbsp;</Center></a></li>
                                                </ul>
                                            </div>
                                            <div class="panel-body">
                                                <div class="tab-content">
                                                    <div class="tab-pane fade in active" id="tab1primary">
                                                        <div class="box-body">
                                                            <div class="form-group">
                                                                <label for="AddNomFiliere">Filière :</label>
                                                                <select id="AddNomFiliere" class="form-control" >
                                                                    <?php foreach ($listeFilieres as $fil): ?>
                                                                        <option value="<?= $fil->id ?>"><?= $fil->nom_filiere ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="AddNomSemestre">Nom du semestre :</label>
                                                                <input type="text" class="form-control" id="AddNomSemestre" placeholder="saisir le nom du semestre">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="AddNomSemestre">Date début du semestre :</label>
                                                                <input type="text" class="form-control addPicker" id="addDebutsemestre">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="AddNomSemestre">Date Fin du semestre :</label>
                                                                <input type="text" class="form-control addPicker" id="addFinsemestre">   
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-block btn-primary btn-lg" onclick="AjouterSemestre($('#AddNomFiliere').val(), $('#AddNomSemestre'), $('#addDebutsemestre'), $('#addFinsemestre'))"><i class="fa fa-plus-circle"></i> Ajouter le semestre <i class="fa fa-plus-circle"></i></button>

                                                    </div>
                                                    <div class="tab-pane fade" id="tab2primary">
                                                        <div class="box-body">
                                                            <div class="form-group">
                                                                <label>Filière :</label>
                                                                <select id="ModifFiliere" class="form-control" onchange="FiliereChanged($(this).val(), $('#ModifSemestreId'))">
                                                                    <?php foreach ($listeFilieres as $fil): ?>
                                                                        <option value="<?= $fil->id ?>"><?= $fil->nom_filiere ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ModifSemestreId">Semestre:</label>
                                                                <select id="ModifSemestreId" class="form-control" >
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ModifNomSemestre">Nouveau Nom du semestre :</label>
                                                                <input type="text" id="ModifNomSemestre" class="form-control" placeholder="saisir le nouveau nom du semestre"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="AddNomSemestre">Date début du semestre :</label>
                                                                <input type="text" class="form-control addPicker" id="ModifDebutsemestre">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="AddNomSemestre">Date Fin du semestre :</label>
                                                                <input type="text" class="form-control addPicker" id="ModifFinsemestre">   
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-block btn-warning btn-lg" onclick="ModifierSemestre($('#ModifSemestreId'), $('#ModifNomSemestre'), $('#ModifDebutsemestre'), $('#ModifFinsemestre'))"><i class="fa fa-edit fa-ho"></i> Modifier le semestre <i class="fa fa-edit"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8" style="margin-top: 20px;">
                                <div class="box">
                                    <div class="box-header">
                                        <h3 class="box-title">Liste Des Semestres : </h3>
                                    </div>
                                    <div class="box-body">
                                        <table id="tableSemestres" class="table table-hover table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>Nom Filière</th>
                                                    <th>Nom Semestre</th>
                                                    <th>Date Début</th>
                                                    <th>Date Fin</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($listeSemestres as $sem): ?>
                                                    <tr>
                                                        <td style="vertical-align: middle"><?= $sem->nom_filiere ?></td>
                                                        <td style="vertical-align: middle"><?= $sem->nomSemestre ?></td>
                                                        <td style="vertical-align: middle"><?= $sem->date_debut ?></td>
                                                        <td style="vertical-align: middle"><?= $sem->date_fin ?></td>
                                                        <td>
                                                <center><button class="btn btn-danger" data-id="<?= $sem->id ?>" data-btn-ok-label="Oui"  data-btn-cancel-label="Non" data-placement="left" data-toggle="confirmation" data-title="Etes vous sure ?"><i class="fa fa-remove"></i></button></center>
                                                </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>    

                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- /.content -->
                </div>
                <!-- /.content-wrapper -->

                <!-- Main Footer -->
                <?php include 'includes/footer.php'; ?>
            </div>

            <style>
                .errors{
                    border: 0;
                    border-bottom: 1px solid red;
                    outline: 0;
                }
            </style>
            <script>
    <?php if (isset($_GET['message'])) { ?>
                    displayNotification(<?= $_GET['message'] ?>, "success");
    <?php } ?>

                $('[data-toggle=confirmation]').confirmation({
                    rootSelector: '[data-toggle=confirmation]',
                    container: 'body',
                    onConfirm: function (event, element) {
                        var row=$(this).parents('tr');
                        $.post("AjaxProcess/GestionSemestres/SupprimerSemestre.php", {id: this.data('id')}, function (data, status) {
                            if (parseInt(data) >= 1) {
                                var t = $('#tableSemestres').DataTable();
                                t.row(row).remove().draw();
                                displayNotification("Semestre supprimé avec succées", "success");
                            } else {
                                displayNotification(data, "danger");
                            }
                        });
                    }
                });

                function ModifierSemestre(id, nom, deb, fin) {
                    nom.removeClass("errors");
                    id.removeClass("errors");
                    deb.removeClass("errors");
                    fin.removeClass("errors");
                    if (id.val() == null || id.val() == '') {
                        id.addClass("errors");
                    } else if (nom.val() == null || nom.val() == '') {
                        nom.addClass("errors");
                    } else if (fin.val() == null || fin.val() == '') {
                        fin.addClass("errors");
                    } else if (deb.val() == null || deb.val() == '') {
                        deb.addClass("errors");
                    } else {
                        $.post("AjaxProcess/GestionSemestres/ModifierSemestre.php", {id: id.val(), nom: nom.val(), debutS: deb.val(), finS: fin.val()}, function (data, status) {
                            if (parseInt(data) >= 1) {
                                window.location.href = 'GestionDesSemestres?message="Semestre modifié avec succés"';
                            } else {
                                displayNotification(data, "danger");
                            }
                        });
                    }
                }

                function AjouterSemestre(nomF, nomS, deb, fin) {
                    nomS.removeClass("errors");
                    deb.removeClass("errors");
                    fin.removeClass("errors");
                    if (nomS.val() == null || nomS.val() == '') {
                        nomS.addClass("errors");
                    } else if (deb.val() == null || deb.val() == '') {
                        deb.addClass("errors");
                    } else if (fin.val() == null || fin.val() == '') {
                        fin.addClass("errors");
                    } else {
                        $.post("AjaxProcess/GestionSemestres/AjouterSemestre.php", {filiere: nomF, nomSemestre: nomS.val(), debutS: deb.val(), finS: fin.val()}, function (data, status) {
                            if (parseInt(data) == 1) {
                                window.location.href = 'GestionDesSemestres?message="Semestre ajouté avec succés"';
                            } else {
                                displayNotification(data, "danger");
                            }
                        });
                    }
                }

                function FiliereChanged(fil, semestre) {
                    $.post("AjaxProcess/GestionCalendrierCours/GetFiliereSemestres.php", {filiereParam: fil}, function (data, status) {
                        semestre.empty();
                        data.forEach(function (obj) {
                            semestre.append("<option value='" + obj.id + "'>" + obj.nomSemestre + "</option>");
                        });
                    });
                }
                $(document).ready(function () {
                    $(".addPicker").datepicker({
                        format: 'yyyy-mm-dd',
                        language: 'fr'
                    });
                    $('#addDebutsemestre').datepicker().on('changeDate', function (ev) {
                        $('#addFinsemestre').datepicker('setStartDate', ev.date);
                    });
                    $('#ModifDebutsemestre').datepicker().on('changeDate', function (ev) {
                        $('#ModifFinsemestre').datepicker('setStartDate', ev.date);
                    });

                    FiliereChanged($("#ModifFiliere").val(), $('#ModifSemestreId'));
                    $('#tableSemestres').DataTable(DataTableParams);
                });
            </script>
        <?php
        } else {
            include 'includes/AccessDenied.php';
        }
        ?>
    </body>
</html>
