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
$controller = new GestionDesEtudiantsController();
$listeFilieres = $controller->getAllFilieres();
$listeEtudiants = $controller->getAllEtudiants();
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="icon" type="image/png" href="Views/dist/img/logo.png" />
        <title>Gestion Etudiants | SuiviSeance</title>
        <script src="Views/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="Views/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="Views/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="Views/dist/css/skins/skin-blue.min.css">
        <link href="Views/plugins/datatables/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
        <script src="Views/bootstrap/js/bootstrap.min.js"></script>
        <script src="Views/plugins/notify.min.js" type="text/javascript"></script>
        <script src="Views/dist/js/app.min.js"></script>
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
            .errors{
                border: 0;
                border-bottom: 1px solid red;
                outline: 0;
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
            }, 1000);</script>
        <?php
        if ($user_priv->hasPrivilege("Gestion Etudiants")) {
            ?>
            <div class="modal modal-primary fade" id="mModifEtud" data-backdrop="false" tabindex="-1" role="dialog" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Modifier un étudiant</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="ModifFiliere">Filière :</label>
                                <select id="ModifFiliere" class="form-control">
                                    <?php foreach ($listeFilieres as $fil): ?>
                                        <option value="<?= $fil->id ?>"><?= $fil->nom_filiere ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ModifCivilite">Civilité étudiant :</label>
                                <input type="text" class="form-control" id="ModifCivilite">
                            </div>
                            <div class="form-group">
                                <label for="ModifEmail">Adresse email étudiant :</label>
                                <input type="email" class="form-control" id="ModifEmail">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" onclick="ModifierEtudiant($('#ModifFiliere').val(), $('#ModifCivilite'), $('#ModifEmail'))">Sauvegarder</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wrapper">
                <!-- Main Header -->
                <?php require_once 'includes/header.php'; ?>
                <!-- Left side column. contains the logo and sidebar -->
                <?php require_once 'includes/Menu.php'; ?>

                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header" >
                        <h3>
                            Gestion des Etudiants
                        </h3>
                    </section>
                    <!-- Main content -->
                    <section class="content">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Ajouter Etudiant </h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="AddFiliere">Filière :</label>
                                                <select id="AddFiliere" class="form-control">
                                                    <?php foreach ($listeFilieres as $fil): ?>
                                                        <option value="<?= $fil->id ?>"><?= $fil->nom_filiere ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="AddCivilite">Civilité étudiant :</label>
                                                <input type="text" class="form-control" id="AddCivilite">
                                            </div>
                                            <div class="form-group">
                                                <label for="AddEmail">Adresse email étudiant :</label>
                                                <input type="email" class="form-control" id="AddEmail">
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-block btn-primary btn-lg" onclick="AjouterEtudiant($('#AddFiliere').val(), $('#AddCivilite'), $('#AddEmail'))"><i class="fa fa-plus-circle fa-ho"></i>&nbsp; Ajouter l'étudiant &nbsp;<i class="fa fa-plus-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8" style="margin-top: 20px;">
                                <div class="box">
                                    <div class="box-header">
                                        <h3 class="box-title">Liste Des Etudiants : </h3>
                                    </div>
                                    <div class="box-body">
                                        <table id="tableEtudiants" class="table table-hover table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>Nom Filière</th>
                                                    <th>Civilité</th>
                                                    <th>Adresse Email</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($listeEtudiants as $etud): ?>
                                                    <tr>
                                                        <td style="vertical-align: middle" ><?= $etud->nom_filiere ?></td>
                                                        <td style="vertical-align: middle"><?= $etud->civilite ?></td>
                                                        <td style="vertical-align: middle"><?= $etud->email ?></td>
                                                        <td>
                                                            <button class="btn btn-danger" data-id="<?= $etud->id ?>" data-btn-ok-label="Oui" data-btn-cancel-label="Non" data-placement="left" data-toggle="confirmation" data-title="Etes vous sure ?"><i class="fa fa-remove"></i></button>
                                                            <button class="btn btn-warning" onclick="showModif(<?= $etud->id ?>,<?= $etud->filId ?>)"><i class="fa fa-edit"></i></button>
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
            <script>
                var currentStudent;
                $('[data-toggle=confirmation]').confirmation({
                    rootSelector: '[data-toggle=confirmation]',
                    container: 'body',
                    onConfirm: function (event, element) {
                        var row = this.parents('tr');
                        var idEtud = this.data('id');
                        $.post("AjaxProcess/GestionEtudiants/SuppEtudiant.php", {id: idEtud}, function (data, status) {
                            if (parseInt(data) >= 1) {
                                var t = $('#tableEtudiants').DataTable();
                                t.row(row).remove().draw();
                                displayNotification("Etudiant supprimé avec succées", "success");
                            } else {
                                displayNotification("Etudiant non supprimé , "+data, "danger");
                            }
                        });
                    }
                });
                
                function showModif(et, fil) {
                    currentStudent = et;
                    $('#ModifFiliere').val(fil);
                    $("#mModifEtud").modal('show');
                }

                function ModifierEtudiant(fil, civ, email) {
                    civ.removeClass("errors");
                    email.removeClass("errors");
                    if (!validateEmail(email.val())) {
                        email.addClass("errors");
                    } else if (civ.val() == null || civ.val() == '') {
                        civ.addClass("errors");
                    } else {
                        $.post("AjaxProcess/GestionEtudiants/ModifierEtudiant.php", {id: currentStudent, fil: fil, civ: civ.val(), email: email.val()}, function (data, status) {
                            if (parseInt(data) >= 1) {
                                location.reload();
                            } else {
                                displayNotification("Etudiant non supprimé , "+data, "danger");
                            }
                        });
                    }
                }
                function AjouterEtudiant(fil, civ, email) {
                    civ.removeClass("errors");
                    email.removeClass("errors");
                    if (!validateEmail(email.val())) {
                        email.addClass("errors");
                    } else if (civ.val() == null || civ.val() == '') {
                        civ.addClass("errors");
                    } else {
                        $.post("AjaxProcess/GestionEtudiants/AjouterEtudiant.php", {fil: fil, civ: civ.val(), email: email.val()}, function (data, status) {
                            if (!isNaN(parseInt(data))) {
                                location.reload();
                            } else {
                                displayNotification("Etudiant non ajouté , "+data, "danger");
                            }
                        });
                    }
                }

                $(document).ready(function () {
                    $('#tableEtudiants').DataTable(DataTableParams);
                });
            </script>

            <?php
        } else {
            include 'includes/AccessDenied.php';
        }
        ?>
    </body>
</html>
