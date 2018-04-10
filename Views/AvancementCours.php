<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<?php
$controller = new AvancementCoursController();
$listeAvancement = $controller->getAvancementCours();
if (isset($_SESSION['googleId'])) {
    $googleId = $_SESSION['googleId'];
    $user_name = $_SESSION['user_name'];
    $user_email = $_SESSION['user_email'];
    $user_img_path = $_SESSION['user_img_path'];
    $user_priv = PrivilegedUser::getByGoogleId($googleId);
} else {
    header("Location: login");
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Avancement des cours | SuiviSeance</title>
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
        <style>
            td[value]:hover:after {
                content: attr(value);
                position: absolute;
                /*top: -100%;*/
                left: 50%;
                color : white;
                background-color: #3C8DBC;
                border-radius : 15px;
                padding :5px;
                border : 1px solid #374850;
                box-shadow: 5px 10px #888888;;
            }
        </style>
        <div class="wrapper">
            <!-- Main Header -->
            <?php require_once 'includes/header.php'; ?>
            <!-- Left side column. contains the logo and sidebar -->
            <?php require_once 'includes/Menu.php'; ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header" >
                    Avancement Cours :
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Liste Des Matières : </h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Professeur</th>
                                            <th>Nom Matiere</th>
                                            <th>Volume d'heures</th>
                                            <th>Nombre séances réalisé</th>
                                            <th>Nombre d'heures réalisé</th>
                                            <th>Nombre de retards</th>
                                            <th>Durée total des retards</th>
                                            <th>Reste a faire</th>
                                            <th>Accomplissement</th>
                                            <th>Responsable scolarité</th>
                                            <th>Directeur pédagogique</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($listeAvancement as $av): ?>
                                            <tr>
                                                <td style="vertical-align: middle" value="<?= 'Email : ' . $av->prof_email . ' | Téléphone : ' . $av->prof_phone ?>"><?= $av->prof_name ?></td>
                                                <td style="vertical-align: middle"><?= $av->nom ?></td>
                                                <td style="vertical-align: middle"><?= $av->volume_heures ?></td>
                                                <td style="vertical-align: middle"><?= $av->total_seance ?></td>
                                                <td style="vertical-align: middle"><?= $controller->convertToHoursMins($av->realise)?></td>
                                                <td style="vertical-align: middle"><?= $av->nbr_retard?></td>
                                                <td style="vertical-align: middle"><?=$av->total_retard>60?$controller->convertToHoursMins( $av->total_retard ):$av->total_retard.' min'?></td>
                                                <td style="vertical-align: middle"><?=$controller->convertToHoursMins($av->reste_a_faire)?></td>
                                                <td style="vertical-align: middle">
                                                    <div class="progress progress-xs progress-striped active">
                                                        <div class="progress-bar progress-bar-success" style="width: <?= (100 * $av->realise) / ($av->volume_heures*60) ?>%"></div>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: middle" value="<?= 'Email : ' . $av->responsable_email . ' | Téléphone : ' . $av->responsable_phone ?>"><?= $av->responsable_name ?></td>
                                                <td style="vertical-align: middle" value="<?= 'Email : ' . $av->directeur_email . ' | Téléphone : ' . $av->directeur_phone ?>"><?= $av->directeur_name ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>    
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
                        displayNotification("Matière supprimé avec succées", "success");
                    } else {
                        displayNotification("Matière non supprimé", "danger");
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
                $('.table').DataTable({
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
