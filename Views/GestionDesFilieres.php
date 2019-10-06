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
$controller = new GestionDesFilieresController();
$listeFilieres = $controller->getAllFilieres();
$listeDirecteurs = $controller->getAllbyRole('Administrateur');
$listeResp = $controller->getAllbyRole('Responsable de scolarité');
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="icon" type="image/png" href="Views/dist/img/logo.png" />
        <title>Gestion Filières | SuiviSeance</title>
        <script src="Views/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="Views/bootstrap/css/bootstrap.min.css">
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
        <?php
        if ($user_priv->hasPrivilege("Gestion Filières")) {
            ?>
        <script>
            jQuery('body').css('display', 'none');
            jQuery(document).ready(function () {
                jQuery('body').fadeIn();
            });
            setTimeout(function () {
                jQuery('body').fadeIn();
            }, 1000);
        </script>
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
                                    <h3 class="box-title">Gestion des filières</h3>
                                </div>
                                <div class="box-body">
                                    <div class="panel with-nav-tabs panel-default">
                                        <div class="panel-heading">
                                            <ul class="nav nav-tabs">
                                                <li class="take-all-space-you-can active"><a href="#tab1primary" data-toggle="tab"><Center><i class="fa fa-plus-circle"></i>&nbsp; Ajouter Filière &nbsp;</Center></a></li>
                                                <li class="take-all-space-you-can"><a href="#tab2primary" data-toggle="tab"><Center><i class="fa fa-edit"></i>&nbsp; Modifier Filière&nbsp;</Center></a></li>
                                            </ul>
                                        </div>
                                        <div class="panel-body">
                                            <div class="tab-content">
                                                <div class="tab-pane fade in active" id="tab1primary">
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label for="AddNomFiliere">Nom Filière :</label>
                                                            <input type="text" id="AddNomFiliere" class="form-control" placeholder="saisir le nom de la filière"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="AddDrPedagog">Directeur pédagogique:</label>
                                                            <select id="AddDrPedagog" class="form-control">
                                                                <?php foreach ($listeDirecteurs as $dr): ?>
                                                                    <option value="<?=$dr->user_id ?>"><?=$dr->user_name ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="AddRs">Responsable de scolarité:</label>
                                                            <select id="AddRs" class="form-control">
                                                                <?php foreach ($listeResp as $rs): ?>
                                                                    <option value="<?= $rs->user_id ?>"><?= $rs->user_name ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="AddEmail">Adresse email de distribution  :</label>
                                                            <input type="email" class="form-control" id="AddEmail">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <button type="button" class="btn btn-block btn-primary btn-lg" onclick="AjouterFiliere($('#AddNomFiliere'), $('#AddDrPedagog').val(), $('#AddRs').val(),$('#AddEmail'))"><i class="fa fa-plus-circle"></i> Ajouter la filière <i class="fa fa-plus-circle"></i></button>
                                                </div>

                                                <div class="tab-pane fade" id="tab2primary">
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label for="ModifFiliereCombo">Nom Filière :</label>
                                                            <select id="ModifFiliereId" class="form-control" >
                                                                <?php foreach ($listeFilieres as $fil): ?>
                                                                 <option value="<?=$fil['id'] ?>"><?=$fil['nom_filiere'] ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="ModifFiliereMatiere">Nouveau Nom de la Filière :</label>
                                                            <input type="text" id="ModifNomFiliere" class="form-control" placeholder="saisir le nouveau nom de la filière"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="AddDrPedagog">Directeur pédagogique:</label>
                                                            <select id="ModifDrPedagog" class="form-control">
                                                                <?php foreach ($listeDirecteurs as $dr): ?>
                                                                    <option value="<?=$dr->user_id ?>"><?=$dr->user_name ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="AddRs">Responsable de scolarité:</label>
                                                            <select id="ModifRs" class="form-control">
                                                                <?php foreach ($listeResp as $rs): ?>
                                                                    <option value="<?= $rs->user_id ?>"><?= $rs->user_name ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="AddEmail">Adresse email de distribution  :</label>
                                                            <input type="email" class="form-control" id="ModifEmail">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <button type="button" class="btn btn-block btn-warning btn-lg" onclick="ModifierFiliere($('#ModifFiliereId').val(), $('#ModifNomFiliere'), $('#ModifDrPedagog').val(), $('#ModifRs').val(),$('#ModifEmail'))"><i class="fa fa-edit fa-ho"></i> Modifier la filière <i class="fa fa-edit"></i></button>
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
                                    <h3 class="box-title">Liste Des Filières : </h3>
                                </div>
                                <div class="box-body">
                                    <table id="tableFilieres" class="table table-hover table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Nom Filière</th>
                                                <th>Semestres</th>
                                                <th>Directeur pédagogique</th>
                                                <th>Responsable de scolarité</th>
                                                <th>@ Email de distribution</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($listeFilieres as $fil): ?>
                                                <tr>
                                                    <td style="vertical-align: middle"><?= $fil['nom_filiere'] ?></td>
                                                    <td style="vertical-align: middle"><?= $fil['semestres'] ?></td>
                                                    <td style="vertical-align: middle"><?= $fil['directeur_pedagogique'] ?></td>
                                                    <td style="vertical-align: middle"><?= $fil['responsable_scolarite'] ?></td>
                                                    <td style="vertical-align: middle"><?= $fil['email_groupe'] ?></td>
                                                    <td>
                                            <center><button class="btn btn-danger" data-id="<?= $fil['id'] ?>" data-btn-ok-label="Oui" data-content="Etes vous sure de vouloir supprimer cette filière ?" data-btn-cancel-label="Non" data-placement="left" data-toggle="confirmation" data-title="Etes vous sure ?"><i class="fa fa-remove"></i></button></center>
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
            $('[data-toggle=confirmation]').confirmation({
                rootSelector: '[data-toggle=confirmation]',
                container: 'body',
                onConfirm: function (event, element) {
                    var row = $(this).parents('tr');
                    $.post("AjaxProcess/GestionFiliere/SuppFiliere.php", {id: this.data('id')}, function (data, status) {
                        if (parseInt(data) >= 1) {
                            var t = $('#tableFilieres').DataTable();
                            t.row(row).remove().draw();
                            displayNotification("Filière supprimé avec succées", "success");
                        } else {
                            displayNotification("Filière non supprimé , "+data, "danger");
                        }
                    });
                }
            });
            
            function ModifierFiliere(id , nom , dr , rs,email) {
                nom.removeClass("errors");
                email.removeClass("errors");
                if (nom.val() == '' || nom.val() == null) {
                    nom.addClass("errors");
                }else if (email.val() == '' || (!validateEmail(email.val()))) {
                    email.addClass("errors");
                }else {
                    $.post("AjaxProcess/GestionFiliere/ModifierFiliere.php", {id :id,nom: nom.val() ,dr: dr , rs : rs,email: email.val()}, function (data, status) {
                    if (parseInt(data)>=1 ) {
                            location.reload();
                        }else{
                            displayNotification("Matière non supprimé ", "danger");
                        }
                    });
                }
            }
            
            function AjouterFiliere(nom, dr, rs,email) {
                email.removeClass("errors");
                nom.removeClass("errors");
                if (nom.val() == '' || nom.val() == null) {
                    nom.addClass("errors");
                }else if (email.val() == '' || (!validateEmail(email.val()))) {
                    email.addClass("errors");
                }else {
                    $.post("AjaxProcess/GestionFiliere/AjouterFiliere.php", {nom: nom.val(), dr: dr, rs: rs,email: email.val()}, function (data, status) {
                        if (parseInt(data) >= 1) {
                            location.reload();
                        } else {
                            displayNotification(data, "danger");
                        }
                    });
                }
            }
            
            $(document).ready(function () {
                $('#tableFilieres').DataTable(DataTableParams);
            });
        </script>

        <!-- Optionally, you can add Slimscroll and FastClick plugins.
             Both of these plugins are recommended to enhance the
             user experience. Slimscroll is required when using the
             fixed layout. -->
        <?php } else {                                        
            include 'includes/AccessDenied.php';
            }?>
    </body>
</html>
