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
$controller = new GestionDesMatieresController();
$listeMatieres = $controller->getAllMatieres();
$listeFilieres = $controller->getAllFilieres();
$listeProfesseur = $controller->getAllProf();
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <link rel="icon" type="image/png" href="Views/dist/img/logo.png" />
        <title>Gestion Matières | SuiviSeance</title>
        <script src="Views/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
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
        <style>
            .tansition{
                transition: 0.5s all ease;
            }
        </style>
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
                                        <i class="fa fa-graduation-cap"></i> &nbsp; &nbsp; Nom de la filière
                                    </div>
                                    <input type="text" disabled class="form-control" id="filInfos">
                                </div>
                                <br>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i> &nbsp; &nbsp; Nom du semestre
                                    </div>
                                    <input type="text" disabled class="form-control" id="seInfos">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="accmInfos" style="color: black;">Accomplissement :</label>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" id="accmInfos" style="width: 0%"></div>
                                    </div>
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
        <?php
        if ($user_priv->hasPrivilege("Gestion Matières")) {
            ?>
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
                            <div class="col-sm-4">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Gestion des Matières</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="panel with-nav-tabs panel-default">
                                            <div class="panel-heading">
                                                <ul class="nav nav-tabs">
                                                    <li class="take-all-space-you-can active"><a href="#tab1primary" data-toggle="tab"><Center><i class="fa fa-plus-circle"></i>&nbsp; Ajouter Matière &nbsp;</Center></a></li>
                                                    <li class="take-all-space-you-can"><a href="#tab2primary" data-toggle="tab"><Center><i class="fa fa-edit"></i>&nbsp; Modifier Matière&nbsp;</Center></a></li>
                                                </ul>
                                            </div>
                                            <div class="panel-body">
                                                <div class="tab-content" id="Tabs">
                                                    <div class="tab-pane fade in active" id="tab1primary">
                                                        <div class="box-body tansition form" id="FormAdd">
                                                            <div class="form-group">
                                                                <label for="FiliereMatiere">Filière :</label>
                                                                <select id="AddFiliereMatiere" class="form-control" onchange="FiliereChanged($(this).val(), $('#AddSemestreMatiere'))">
                                                                    <?php foreach ($listeFilieres as $fil): ?>
                                                                        <option value="<?= $fil->id ?>"><?= $fil->nom_filiere ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="AddSemestreMatiere">Semestre :</label>
                                                                <select id="AddSemestreMatiere" class="form-control">
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="FiliereMatiere">Nom Matière :</label>
                                                                <input type="text" id="AddNomMatiere" class="form-control" placeholder="saisir le nom de la matière"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="nomMatiere">Volume d'heures :</label>
                                                                <input type="number" class="form-control" min="0" step="1" id="AddVolumeMatiere" placeholder="saisir le volume d'heures">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Addsemestre">Prix par heure :</label>
                                                                <input type="number" class="form-control" id="AddPrixMatiere" placeholder="saisir le prix par heure">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="prof">Professeur :</label>
                                                                <select id="AddProfMatiere" class="form-control">
                                                                    <?php foreach ($listeProfesseur as $prof): ?>
                                                                        <option value="<?= $prof->user_id ?>"><?= $prof->user_name ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="prof">Couleur par défaut de la matière  :</label>
                                                                <div class = "input-group">
                                                                    <div class = "btn-group" style = "width: 100%; margin-bottom: 10px;">
                                                                        <ul class = "fc-color-picker" id = "color-chooser">
                                                                            <li><a class = "text-aqua" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-blue" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-light-blue" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-teal" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-yellow" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-orange" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-green" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-lime" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-red" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-purple" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-fuchsia" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-muted" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-navy" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-maroon" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-danger" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-olive" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-block btn-primary btn-lg" onclick="AjouterMatiere()"><i class="fa fa-plus-circle fa-ho"></i>&nbsp; Ajouter la matière &nbsp;<i class="fa fa-plus-circle"></i></button>
                                                    </div>

                                                    <div class="tab-pane fade" id="tab2primary">
                                                        <div class="box-body tansition form">
                                                             <div class="form-group">
                                                                <label for="FiliereMatiere">Nouveau nom de la Matière :</label>
                                                                <input type="text" id="ModifNomMatiere" class="form-control" placeholder="saisir le nom de la matière"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ModifFiliereMatiere">Filière :</label>
                                                                <select id="ModifFiliereMatiere" class="form-control" onchange="FiliereChanged($(this).val(), $('#ModifSemestreMatiere'))">
                                                                    <?php foreach ($listeFilieres as $fil): ?>
                                                                        <option value="<?= $fil->id ?>"><?= $fil->nom_filiere ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label for="ModifSemestreMatiere">Semestre:</label>
                                                                <select id="ModifSemestreMatiere" class="form-control" >
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ModifVolumeMatiere">Volume d'heures :</label>
                                                                <input type="number" class="form-control" min="0" step="1" id="ModifVolumeMatiere" placeholder="saisir le volume d'heures">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ModifPrixMatiere">Prix par heure :</label>
                                                                <input type="number" class="form-control" id="ModifPrixMatiere" placeholder="saisir le prix par heure">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="prof">Professeur :</label>
                                                                <select id="ModifProfMatiere" class="form-control">
                                                                    <?php foreach ($listeProfesseur as $prof): ?>
                                                                        <option value="<?= $prof->user_id ?>"><?= $prof->user_name ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="prof">Couleur par défaut de la matière  :</label>
                                                                <div class = "input-group">
                                                                    <div class = "btn-group" style = "width: 100%; margin-bottom: 10px;">
                                                                        <ul class = "fc-color-picker" id = "color-chooser">
                                                                            <li><a class = "text-aqua" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-blue" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-light-blue" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-teal" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-yellow" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-orange" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-green" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-lime" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-red" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-purple" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-fuchsia" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-muted" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-navy" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-maroon" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-danger" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                            <li><a class = "text-olive" href = "#"><i class = "fa fa-square"></i></a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-block btn-warning btn-lg" onclick="ModifierMatiere()"><i class="fa fa-edit"></i>&nbsp; Modifier la matière &nbsp;<i class="fa fa-edit"></i></button>
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
                                        <h3 class="box-title">Liste Des Matières : </h3>
                                    </div>
                                    <div class="box-body">
                                        <table id="tableMatieres" class="table table-hover table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>Nom Matiere</th>
                                                    <th>Volume d'heures</th>
                                                    <th>Prix par heures</th>
                                                    <th>Professeur</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($listeMatieres as $etud): ?>
                                                    <tr>
                                                        <td style="vertical-align: middle"><?= $etud->nom ?></td>
                                                        <td style="vertical-align: middle"><?= $etud->volume_heures . ' h' ?></td>
                                                        <td style="vertical-align: middle"><?= $etud->prix_par_heure . ' DH' ?></td>
                                                        <td style="vertical-align: middle"><?= $etud->user_name ?></td>
                                                        <td>
                                                            <button class="btn btn-primary" onclick="showInfos(<?= $etud->id ?>)"><i class="fa fa-info"></i></button>
                                                            <button class="btn btn-warning" onclick="showModif(<?= $etud->id ?>,$(this).parents('tr'))"><i class="fa fa-edit"></i></button>
                                                            <button class="btn btn-danger" data-id="<?= $etud->id ?>" data-btn-ok-label="Oui" data-content="Cela implique la suppression des séance de cette matière et de perdre son avancement" data-btn-cancel-label="Non" data-placement="left" data-toggle="confirmation" data-title="Etes vous sure ?"><i class="fa fa-remove"></i></button>
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

                <!-- Salut je suis oumaima , j'ai une belle voix mais je dit toujours qu'elle est pas bien 
                je suis aussi charmante que drole , je sais que je ne suis pas supposé etre la mais dak nabil de5elni
                -->
                <?php include 'includes/footer.php'; ?>
                <!-- Salut je suis nabil , ant3aned m3a oumaima ou mabghitch nkheliha hna bou7dha , ana houwa li msayeb had l3jeb 
                soo ila l9itou hadchi 3erfouni ha knt tanez ou hal3ar lamad3iwnich wla tbghiw trej3ou rze9koum 7it aslan ankoun deja
                tkhelesst niahahaha 
                -->
                
                <!-- Aslan c'est pas mon idée walakin ntouma z9armiya ou 7ema9 aww tnin fl3chia b7ala ana ma3andi maydar ha votre projet
                    3refti chghadir ana anhder m3a oumaima ou li liha liha
                -->
            </div>

            <style>
                .errors{
                    border: 0;
                    border-bottom: 1px solid red;
                    outline: 0;
                }
            </style>
            <script>
        var CurrentMat=-1;
        var SelectedRow=null;
        function showInfos(id) {
            $.post("AjaxProcess/GestionMatiere/GetInfos.php", {id: id}, function (data, status) {
                $('#accmInfos').css({"width": (data.acomp == null ? 0 : data.acomp) + '%'});
                if (data.filiere == null) {
                    $('#filInfos').val("Aucune filière associé a cette matière");
                } else {
                    $('#filInfos').val(data.filiere);
                }
                if (data.semestre == null) {
                    $('#seInfos').val("Aucun semestre associé a cette matière");
                } else {
                    $('#seInfos').val(data.semestre);
                }
            });
            $("#Infos").modal('show');
        }
        function showModif(id,tr) {
            CurrentMat=id;
            var t = $('#tableMatieres').DataTable();
            jQuery(t.rows().nodes()).each(function () {
                jQuery(this).css({"background-color": "white"});
            });
            tr.css({"background-color": "#BEE5EB"});
            $.post("AjaxProcess/GestionMatiere/GetModifierInfos.php", {id: id}, function (data, status) {
                $('#ModifNomMatiere').val(data.nom);
                $('#ModifVolumeMatiere').val(data.volume_heures);
                $('#ModifPrixMatiere').val(data.prix_par_heure);
                $('#ModifProfMatiere').val(data.id_prof);
                    if (!(data.metadata == null)) {
                        $('.form').css({"background-color": data.metadata.backgroundColor, "border-color": data.metadata.backgroundColor, "color": "#FFFFFF"});
                    }
                    });
            $('.nav-tabs a[href="#tab2primary"]').tab('show');
        }

        var backcol = "#3c8dbc";
        var metadata = "{\"allDay\" : false, \"backgroundColor\": \"#3c8dbc\", \"borderColor\": \"#3c8dbc\"}";
        var colorChooser = $("#color-chooser-btn");
        $("#color-chooser > li > a").click(function (e) {
            e.preventDefault();
            backcol = $(this).css("color");
            metadata = "{ \"allDay\" : false, \"backgroundColor\": \"" + rgb2hex(backcol.toString()) + "\", \"borderColor\": \"" + rgb2hex(backcol.toString()) + "\"}";
            $('.form').css({"background-color": backcol, "border-color": backcol, "color": "#FFFFFF"});
        });

        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            container: 'body',
            onConfirm: function (event, element) {
                var row = this.parents('tr');
                var idMat = this.data('id');
                $.post("AjaxProcess/GestionMatiere/SuppMatiere.php", {id: idMat}, function (data, status) {
                    if (parseInt(data) >= 1) {
                        var t = $('#tableMatieres').DataTable();
                        t.row(row).remove().draw();
                        $("#ModifNomMatiere option[value='" + idMat + "']").remove();
                        displayNotification("Matière supprimé avec succées", "success");
                    } else {
                        displayNotification("Matière non supprimé ,"+data, "danger");
                    }
                });
            }
        });
        function ModifierMatiere() {
            if(CurrentMat > -1){
            var semestre= $('#ModifSemestreMatiere');
            var volume = $('#ModifVolumeMatiere');
            var prix = $('#ModifPrixMatiere');
            var matiere = $("#ModifNomMatiere");
            matiere.removeClass("errors");
            semestre.removeClass("errors");
            volume.removeClass("errors");
            prix.removeClass("errors");
            if (semestre.val()==null || semestre.val() == '') {
                semestre.addClass("errors");
            }else if (matiere.val()==null || matiere.val() == '') {
                matiere.addClass("errors");
            }else if (!isNaN(volume) || volume.val() == '') {
                volume.addClass("errors");
            } else if (!isNaN(prix) || prix.val() == '') {
                prix.addClass("errors");
            } else {
                $.post("AjaxProcess/GestionMatiere/ModifierMatiere.php", {id : CurrentMat , nom : matiere.val(), volume_heure: volume.val(), metadata: metadata, prixHeure: prix.val(), semestre: semestre.val(), prof: $("#ModifProfMatiere").val()}, function (data, status) {
                    if (isNaN(parseInt(data))) {
                        displayNotification("Matière non modifié", "danger");
                    } else {
                        location.reload();
                    }
                });
                }
            }else{
                    displayNotification("Veuillez sélectionner une matière", "danger");
            }
        }
        function AjouterMatiere() {
            var matiere = $('#AddNomMatiere');
            var volume = $('#AddVolumeMatiere');
            var prix = $('#AddPrixMatiere');
            var semestre = $("#AddSemestreMatiere");
            matiere.removeClass("errors");
            semestre.removeClass("errors");
            volume.removeClass("errors");
            prix.removeClass("errors");
            if (semestre.val() == '' || semestre.val() == null) {
                semestre.addClass("errors");
            } else if (matiere.val() == '' || matiere.val() == null) {
                matiere.addClass("errors");
            } else if (!isNaN(volume) || volume.val() == '') {
                volume.addClass("errors");
            } else if (!isNaN(prix) || prix.val() == '') {
                prix.addClass("errors");
            } else {
                $.post("AjaxProcess/GestionMatiere/AjouterMatiere.php", {nom: matiere.val(), volume_heure: volume.val(), prixHeure: prix.val(), semestre: semestre.val(), prof: $("#AddProfMatiere").val(), metadata: metadata}, function (data, status) {
                    if (!isNaN(parseInt(data))) {
                        location.reload();
                    } else {
                        displayNotification("Matière non ajouté , "+data, "danger");
                    }
                });
            }
        }

        //                                                                function loadMatieres(semestre) {
        //                                                                    $("#ModifNomMatiere").empty();
        //                                                                    $.post("AjaxProcess/GestionCalendrierCours/GetSemestreMatieres.php", {semestreParam: semestre}, function (data, status) {
        //                                                                        data.forEach(function (obj) {
        //                                                                            $("#ModifNomMatiere").append("<option value='" + obj.id + "'>" + obj.nom + "</option>");
        //                                                                        });
        //                                                                    });
        //                                                                }

        function FiliereChanged(fil, semestre) {
            $.post("AjaxProcess/GestionCalendrierCours/GetFiliereSemestres.php", {filiereParam: fil}, function (data, status) {
                semestre.empty();
                data.forEach(function (obj) {
                    semestre.append("<option value='" + obj.id + "'>" + obj.nomSemestre + "</option>");
                });
        //                                                                        if (isModif) {
        //                                                                            loadMatieres($('#ModifSemestreMatiere').val());
        //                                                                        }
            });
        }
        $(document).ready(function () {
            FiliereChanged($("#ModifFiliereMatiere").val(), $('#ModifSemestreMatiere'));
            FiliereChanged($('#AddFiliereMatiere').val(), $('#AddSemestreMatiere'));
            $('#tableMatieres').DataTable(DataTableParams);
        });
    </script>

    <?php
} else {
    include 'includes/AccessDenied.php';
}
?>
    </body>
</html>
