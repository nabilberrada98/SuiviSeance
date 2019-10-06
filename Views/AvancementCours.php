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
$controller = new AvancementCoursController();
if ($user_priv->hasPrivilege("Voir état avancement de tous les cours")) {
    $listeAvancement = $controller->getAvancementCours();
} else {
    $listeAvancement = $controller->getAvancementCours($user_priv->user_id);
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <link rel="icon" type="image/png" href="Views/dist/img/logo.png" />
        <title>Avancement des cours | SuiviSeance</title>
        <script src="Views/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="Views/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="Views/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="Views/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="Views/dist/css/skins/skin-blue.min.css">
        <link href="Views/plugins/datatables/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            .hoverebale:hover{
                color: #3C8DBC;
                cursor: help;
            }
        </style>
    </head>
    <body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
        <div class="modal modal-primary fade" id="Infos" data-backdrop="false" tabindex="-1" role="dialog" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Informations</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box box-info">
                            <div class="box-body">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-book"></i> &nbsp; &nbsp; Adresse email
                                    </div>
                                    <input type="text" disabled class="form-control" id="AdresseEmailInfo">
                                </div>
                                <br>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-key"></i> &nbsp; &nbsp; Numéro de téléphone
                                    </div>
                                    <input type="text" disabled class="form-control" id="TelefInfo">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
         <div class="modal modal-primary fade" id="InfoMatiere" data-backdrop="false" tabindex="-1" role="dialog" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Informations sur la matière</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box box-info">
                            <div class="box-body">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-book"></i> &nbsp; &nbsp; Filière
                                    </div>
                                    <input type="text" disabled class="form-control" id="filInfo">
                                </div>
                                <br>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-key"></i> &nbsp; &nbsp; Semestre
                                    </div>
                                    <input type="text" disabled class="form-control" id="SemInfo">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
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
                <section class="content">
                    <div class="row">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Avancement des Cours : </h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Nom Matiere</th>
                                            <th>Professeur</th>
                                            <th>Volume d'heures</th>
                                            <th>Nombre séances réalisé</th>
                                            <th>Nombre d'heures réalisé</th>
                                            <th>Nombre de retards</th>
                                            <th>Durée total des retards</th>
                                            <th>Reste a faire</th>
                                            <th>séances restante</th>
                                            <th>Accomplissement</th>
                                            <th>Accomplissement Semestre</th>
                                            <th>Responsable de scolarité</th>
                                            <th>Directeur pédagogique</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($listeAvancement as $av):
                                            $percent=(100 * $av->realise) / ($av->volume_heures * 60);
                                            $avMax =$av->RealisationSemestre>=100?100 :$av->RealisationSemestre;
                                            ?>
                                        <tr <?php if(($av->RealisationSemestre-$percent)>=25){ echo "style='background-color: #F5C6CB;' "; }else if(($av->RealisationSemestre-$percent) > 10 ){echo "style='background-color: #FFEEBA;' "; } ?> > 
                                            <td style="vertical-align: middle" class="hoverebale" filiere="<?= $av->nom_filiere ?>" semestre="<?= $av->nomSemestre ?>" onclick="showInfoMatiere($(this).attr('filiere'), $(this).attr('semestre'))"><?= $av->nom ?></td>
                                                <td class="hoverebale" onclick="showInfos('Information sur le Professeur',$(this).attr('email'), $(this).attr('phone'))" email="<?= $av->prof_email ?>" phone="<?= $av->prof_phone ?>"  ><?= $av->prof_name ?></td>
                                                <td style="vertical-align: middle"><?= $av->volume_heures ?></td>
                                                <td style="vertical-align: middle"><?= $av->total_seance ?></td>
                                                <td style="vertical-align: middle"><?= $controller->convertToHoursMins($av->realise) ?></td>
                                                <td style="vertical-align: middle"><?= $av->nbr_retard ?></td>
                                                <td style="vertical-align: middle"><?= $av->total_retard > 60 ? $controller->convertToHoursMins($av->total_retard) : $av->total_retard . ' min' ?></td>
                                                <td style="vertical-align: middle"><?= $controller->convertToHoursMins($av->reste_a_faire) ?></td>
                                                <td><?=Round($av->reste_a_faire/90)?></td>
                                                <td style="vertical-align: middle">
                                                    <div class="progress progress-xs progress-striped active">
                                                        <div class="progress-bar progress-bar-success" style="width: <?=$percent?>%"><?=round($percent)?>%</div>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: middle">
                                                    <div class="progress progress-xs progress-striped active">
                                                        <div class="progress-bar <?=$av->RealisationSemestre>=85 ?'progress-bar-red':$av->RealisationSemestre>=50 ?'progress-bar-warning':'progress-bar-success' ?>" style="width: <?=$av->RealisationSemestre?>%"><?=round($avMax)?>%</div>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: middle" class="hoverebale" onclick="showInfos('Information sur le Responsable de scolarité',$(this).attr('email'), $(this).attr('phone'))" email="<?= $av->responsable_email ?>" phone="<?= $av->responsable_phone ?>"><?= $av->responsable_name ?></td>
                                                <td style="vertical-align: middle" class="hoverebale" onclick="showInfos('Information sur le Directeur pédagogique',$(this).attr('email'), $(this).attr('phone'))" email="<?= $av->directeur_email ?>" phone="<?= $av->directeur_phone ?>"><?= $av->directeur_name ?></td>
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
        <!-- REQUIRED JS SCRIPTS -->

        <script src="Views/bootstrap/js/bootstrap.min.js"></script>
        <script src="Views/plugins/notify.min.js" type="text/javascript"></script>
        <script src="Views/dist/js/app.min.js"></script>
        <script src="Views/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="Views/plugins/datatables/dataTables.bootstrap.min.js"></script>
        <script src="Views/personnalJs/Utils.js" type="text/javascript"></script>
        <script>
                                                function showInfos(title,email, phone) {
                                                    $("#AdresseEmailInfo").val(email);
                                                    $("#TelefInfo").val(phone);
                                                    $('#Infos .modal-title').text(title);
                                                    $("#Infos").modal('show');
                                                }
                                                function showInfoMatiere(fil,sem) {
                                                    $("#filInfo").val(fil);
                                                    $("#SemInfo").val(sem);
                                                    $("#InfoMatiere").modal('show');
                                                }
                                                $(document).ready(function () {
                                                    $('.table').DataTable(DataTableParams);
                                                });
        </script>
    </body>
</html>
