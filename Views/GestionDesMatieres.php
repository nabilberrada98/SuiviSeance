<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<?php
$controller = new GestionDesMatieresController();
$matiere = $controller->getAllMatieres();
$controller->getAllFilieres();
if (isset($_SESSION['googleId'])) {
    $googleId = $_SESSION['googleId'];
    $user_name = $_SESSION['user_name'];
    $user_email = $_SESSION['user_email'];
    $user_img_path = $_SESSION['user_img_path'];
    $user_priv = PrivilegedUser::getByGoogleId($googleId);
} else {
    header("Location: login");
}
$controller = null;
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Gestion Matière | SuiviSeance</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="Views/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="Views/dist/css/AdminLTE.min.css">

        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
              page. However, you can choose any other skin. Make sure you
              apply the skin class to the body tag so the changes take effect.
        -->
        <link rel="stylesheet" href="Views/dist/css/skins/skin-blue.min.css">
        <link href="Views/plugins/datatables/jquery.dataTables.css" rel="stylesheet" type="text/css"/>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
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
                <!-- Content Header (Page header) -->
                <section class="content-header" >
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Enregistrer une matière </h3>
                                </div>
                                <div class="box-body">
                                    <div class="panel with-nav-tabs panel-default">
                                        <div class="panel-heading">
                                            <ul class="nav nav-tabs">
                                                <li class="take-all-space-you-can active"><a href="#tab1primary" data-toggle="tab"><Center><i class="fa fa-plus-circle"></i>&nbsp; Ajouter Matiére &nbsp;</Center></a></li>
                                                <li class="take-all-space-you-can"><a href="#tab2primary" data-toggle="tab"><Center><i class="fa fa-edit"></i>&nbsp; Modifier Matiére&nbsp;</Center></a></li>
                                                <li class="take-all-space-you-can"><a href="#tab3primary" data-toggle="tab"><Center><i class="fa fa-trash"></i>&nbsp; Supprimer Matiére&nbsp;</Center></a></li>
                                            </ul>
                                        </div>
                                        <div class="panel-body">
                                            <div class="tab-content">
                                                <div class="tab-pane fade in active" id="tab1primary">
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label for="FiliereMatiere">Nom Matière :</label>
                                                            <input type="text" id="addMatiere" class="form-control"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nomMatiere">Nom Matière :</label>
                                                            <input type="text" class="form-control" id="nomMatiere" placeholder="saisir le nom de la matière">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Addsemestre">Semestre :</label>
                                                            <select id="Addsemestre" class="form-control">

                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="vh">Volume d'heures :</label>
                                                            <input type="text" class="form-control" id="vh" placeholder="saisir le volume d'heures">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="prof">Professeur :</label>
                                                            <input type="text" id="prof" class="form-control" placeholder="saisir le volume d'heures restant">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <button type="button" class="btn btn-block btn-danger btn-lg" onclick="AjouterMatiere()"><i class="fa fa-trash fa-ho"></i> Ajouter la matière <i class="fa fa-trash"></i></button>
                                                </div>

                                                <div class="tab-pane fade" id="tab2primary">
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label for="FiliereMatiere">Nom Matière :</label>
                                                            <select id="FiliereMatiere" class="form-control">

                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nomMatiere">Nom Matière :</label>
                                                            <input type="text" class="form-control" id="nomMatiere" placeholder="saisir le nom de la matière">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Addsemestre">Semestre :</label>
                                                            <select id="Addsemestre" class="form-control">

                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="vh">Volume d'heures :</label>
                                                            <input type="text" class="form-control" id="vh" placeholder="saisir le volume d'heures">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="prof">Professeur :</label>
                                                            <input type="text" id="prof" class="form-control" placeholder="saisir le volume d'heures restant">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <button type="button" class="btn btn-block btn-warning btn-lg" onclick="SupprimerMatiere()"><i class="fa fa-trash fa-ho"></i> Supprimer la matière <i class="fa fa-trash"></i></button>
                                                </div>
                                                <div class="tab-pane fade" id="tab3primary">
                                                    <div class="box-body">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-question-circle">&nbsp;</i>&nbsp;Nom Matière </span>
                                                            <select id="SuppNomMatiere" class="form-control">
                                                                <option value="1">CCNA</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <button type="button" class="btn btn-block btn-danger btn-lg" onclick="SupprimerMatiere()"><i class="fa fa-trash fa-ho"></i> Supprimer la matière <i class="fa fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-top: 20px;">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Liste Des Matières : </h3>
                                </div>
                                <div class="box-body">
                                    <table id="tableMatieres"  class="table table-hover table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Nom Matiere</th>
                                                <th>Volume d'heure</th>
                                                <th>Heures restante</th>
                                                <th>Professeur</th>
                                                <th>Accomplissement</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="vertical-align: middle">CCNA</td>
                                                <td style="vertical-align: middle">43</td>
                                                <td style="vertical-align: middle">3</td>
                                                <td style="vertical-align: middle">Rais</td>
                                                <td style="vertical-align: middle">
                                                    <div class="progress progress-xs progress-striped active">
                                                        <div class="progress-bar progress-bar-success" style="width: 50.7%"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: middle">Systeme</td>
                                                <td style="vertical-align: middle">43</td>
                                                <td style="vertical-align: middle">4</td>
                                                <td style="vertical-align: middle">Rais</td>
                                                <td style="vertical-align: middle">
                                                    <div class="progress progress-xs progress-striped active">
                                                        <div class="progress-bar progress-bar-success" style="width: 50.7%"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: middle">Java fx</td>
                                                <td style="vertical-align: middle">43</td>
                                                <td style="vertical-align: middle">13</td>
                                                <td style="vertical-align: middle">yahyaoui</td>
                                                <td style="vertical-align: middle">
                                                    <div class="progress progress-xs progress-striped active">
                                                        <div class="progress-bar progress-bar-success" style="width: 50.7%"></div>
                                                    </div>
                                                </td>
                                            </tr>
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
        <!-- ./wrapper -->

        <!-- REQUIRED JS SCRIPTS -->

        <!-- jQuery 2.2.3 -->
        <script src="Views/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="Views/bootstrap/js/bootstrap.min.js"></script>
        <!-- AdminLTE App -->
        <script src="Views/plugins/notify.min.js" type="text/javascript"></script>
        <script src="Views/dist/js/app.min.js"></script>
        <script src="Views/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="Views/plugins/datatables/dataTables.bootstrap.min.js"></script>
        <script>
                                                        function SupprimerMatiere() {
                                                            $.post("AjaxProcess/GestionMatiere/SuppMatiere.php", {idMatiere: $("#SuppNomMatiere").val()}, function (data, status) {
                                                                if (parseInt(data) >= 1) {
                                                                    displayNotification("Matière supprimé avec succées","success");
                                                                }else{
                                                                    displayNotification("Matière non supprimé","danger");
                                                                }
                                                            });
                                                        }

                                                        function displayNotification(text, className) {
                                                            $.notify(text, {
                                                                clickToHide: true,
                                                                autoHide: true,
                                                                autoHideDelay: 3000,
                                                                arrowShow: true,
                                                                arrowSize: 150,
                                                                className: className,
                                                                gap: 120
                                                            });
                                                        }
                                                        $(document).ready(function () {
                                                            $('#tableMatieres').DataTable({
                                                                language: {
                                                                    processing: "Traitement en cours...",
                                                                    search: "Rechercher&nbsp;:",
                                                                    lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
                                                                    info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                                                                    infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                                                                    infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                                                                    infoPostFix: "",
                                                                    loadingRecords: "Chargement en cours...",
                                                                    zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
                                                                    emptyTable: "Aucune donnée disponible dans le tableau",
                                                                    paginate: {
                                                                        first: "Premier",
                                                                        previous: "Pr&eacute;c&eacute;dent",
                                                                        next: "Suivant",
                                                                        last: "Dernier"
                                                                    }},
                                                                "paging": true,
                                                                "lengthChange": true,
                                                                "searching": true,
                                                                "ordering": true,
                                                                "info": true,
                                                                "autoWidth": true
                                                            });

                                                        });
        </script>

        <!-- Optionally, you can add Slimscroll and FastClick plugins.
             Both of these plugins are recommended to enhance the
             user experience. Slimscroll is required when using the
             fixed layout. -->
    </body>
</html>
