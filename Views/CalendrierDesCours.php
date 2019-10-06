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
$controller = new CalendrierDesCoursController();
$profs = $controller->getAllProffeseurs();
$filieres = $controller->getAllFilieres();
$controller = null;
?>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="Views/dist/img/logo.png" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Calendrier des séances de cour</title>
        <!-- Tell the browser to be responsive to screen width -->
        <script src="Views/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="Views/dist/js/loadingoverlay.min.js" type="text/javascript"></script>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link href="Views/dist/css/animate.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="Views/plugins/iCheck/square/red.css">
        <link rel="stylesheet" href="Views/bootstrap/css/bootstrap.min.css">
        <!--<link href="Views/dist/css/ftAwesomeAnims.css" rel="stylesheet" type="text/css"/>-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="Views/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="Views/plugins/daterangepicker/daterangepicker.css">
        <link rel="stylesheet" href="Views/dist/css/skins/skin-blue.min.css">
        <link href="Views/Full Cal/fullcalendar.css" rel="stylesheet" type="text/css"/>
        <link href="Views/Full Cal/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        <link href="Views/plugins/datetimepicker/datetimepicker.css" rel="stylesheet" type="text/css"/>
        <link href="Views/plugins/datatables/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            .take-all-space-you-can{
                width:16.66666666667%;
            }
            .errors{
                border: 0;
                border-bottom: 1px solid red;
                outline: 0;
            }
        </style>
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <?php if ($user_priv->hasPrivilege("Insérer état avancement") || $user_priv->hasPrivilege("Supprimer état avancement") || $user_priv->hasPrivilege("Modifier état avancement") || $user_priv->hasPrivilege("Enregistrer absense") || $user_priv->hasPrivilege("Enregistrer retard")) { ?>
            <datalist id="motifsDefault">
                <option value="Professeur Malade">
                <option value="Eléve a perturbé le cour">    
            </datalist>

            <div class="modal modal-primary fade" id="CRUDmodal" data-backdrop="false" tabindex="-1" role="dialog" >
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Plus</h4>
                        </div>
                        <div class="modal-body">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                </div>
                                <div class="box-body">
                                    <div class="panel with-nav-tabs panel-default">
                                        <div class="panel-heading">
                                            <ul class="nav nav-tabs">
                                                <li class="take-all-space-you-can active"><a href="#tab1primary" data-toggle="tab"><Center><i class="fa fa-info-circle"></i>&nbsp; Information &nbsp;</Center></a></li>
                                                <?php if ($user_priv->hasPrivilege("Enregistrer retard")) { ?>
                                                    <li class="take-all-space-you-can"><a href="#tab6primary" data-toggle="tab"><Center><i class="fa fa-clock-o"></i>&nbsp; Enregistrer retard &nbsp;</Center></a></li>
                                                <?php } if ($user_priv->hasPrivilege("Enregistrer absense")) { ?>
                                                    <li class="take-all-space-you-can"><a href="#tab2primary" data-toggle="tab"><Center><i class="fa fa-trash"></i>&nbsp; Annulé Séance &nbsp;</Center></a></li>
                                                <?php } ?>
                                                <li class="take-all-space-you-can"><a href="#tab3primary" data-toggle="tab"><Center><i class="fa fa-group"></i>&nbsp; Liste intervenants &nbsp;</Center></a></li>
                                                <?php if ($user_priv->hasPrivilege("Modifier état avancement")) { ?>
                                                    <li class="take-all-space-you-can"><a href="#tab4primary" data-toggle="tab"><Center><i class="fa fa-edit"></i>&nbsp; Modifier &nbsp;</Center></a></li>
                                                    <?php
                                                }
                                                if ($user_priv->hasPrivilege("Supprimer état avancement")) {
                                                    ?>
                                                    <li class="take-all-space-you-can"><a href="#tab5primary" data-toggle="tab"><Center><i class="fa fa-trash"></i>&nbsp; Supprimer &nbsp;</Center></a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="panel-body">
                                            <div class="tab-content">
                                                <div class="tab-pane fade in active" id="tab1primary">
                                                    <div class="box-body">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-book">&nbsp;</i>&nbsp;Matière </span>
                                                            <p class="form-control" id="infoMatiere"></p>
                                                        </div>
                                                        <br>  
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-graduation-cap">&nbsp;</i>&nbsp;Professeur</span>
                                                            <p class="form-control" id="infoProf"></p>
                                                        </div>
                                                        <br>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-clock-o">&nbsp;</i>&nbsp;Date et heure de la séance</span>
                                                            <p class="form-control" id="infoRangeDate"></p>
                                                        </div>
                                                        <br>  
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-heartbeat">&nbsp;</i>&nbsp;Etat</span>
                                                            <p class="form-control" id="infoEtat"></p>
                                                        </div>
                                                        <br>  
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-question-circle">&nbsp;</i>&nbsp;Motif</span>
                                                            <p class="form-control" id="infoMotif"></p>
                                                        </div>
                                                        <br>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-clock-o">&nbsp;</i>&nbsp;Retard</span>
                                                            <p class="form-control" id="infoRetard"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if ($user_priv->hasPrivilege("Modifier état avancement")) { ?>
                                                    <div class="tab-pane fade" id="tab4primary">
                                                        <div class="box-body">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-book">&nbsp;</i>&nbsp;Matière : </span>
                                                                <select class="form-control matiereSelect" id="matiereModif">
                                                                </select>
                                                            </div>
                                                            <br>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa  fa-clock-o">&nbsp;</i>&nbsp;Date et heure de la début de la séance</span>
                                                                <input type="text" class="form-control pull-right ModifPicker" id="ModifDebutseance">
                                                            </div>
                                                            <br>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa  fa-clock-o">&nbsp;</i>&nbsp;Date et heure de la fin de la séance</span>
                                                                <input type="text" class="form-control pull-right ModifPicker" id="ModifFinseance">
                                                            </div>
                                                            <br>
                                                            <button type="button" class="btn btn-block btn-primary btn-lg" onclick="ModifierSeance()"><i class="fa fa-edit"></i> Modifier la séance <i class="fa fa-edit"></i></button>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class = "tab-pane fade" id = "tab3primary">
                                                    <div class = "box-body">
                                                        <table id = "tableIntervenants" class = "table table-hover table-responsive">
                                                            <thead>
                                                                <tr>
                                                                    <th>Civilité</th>
                                                                    <th>Adresse Email</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>

                                                <?php if ($user_priv->hasPrivilege("Supprimer état avancement")) {
                                                    ?>
                                                    <div class = "tab-pane fade" id = "tab5primary">
                                                        <button type = "button" class = "btn btn-block btn-danger btn-lg" onclick = "SupprimerSeance()"><i class = "fa fa-clock-o"></i> Supprimer définitivement la séance <i class = "fa fa-clock-o"></i></button>
                                                    </div>
                                                <?php } ?>
                                                <div class = "tab-pane fade" id = "tab6primary">
                                                    <div class = "input-group">
                                                        <span class = "input-group-addon"><i class = "fa fa-clock-o">&nbsp;
                                                            </i>&nbsp;
                                                            Durée de retard (min)</span>
                                                        <select class = "form-control"id = "retardDuree" >
                                                            <option>5</option>
                                                            <option>10</option>
                                                            <option>15</option>
                                                            <option>20</option>
                                                            <option>25</option>
                                                            <option>30</option>
                                                            <option>35</option>
                                                            <option>40</option>
                                                            <option>45</option>
                                                            <option>50</option>
                                                            <option>55</option>
                                                            <option>60</option>
                                                        </select>
                                                    </div>
                                                    <br>
                                                    <button type = "button" class = "btn btn-block btn-warning btn-lg" onclick = "EnregistrerRetard($('#retardDuree option:selected').text())"><i class = "fa fa-trash"></i> Enregistrer un retard pour la séance <i class = "fa fa-trash"></i></button>
                                                </div>
                                                <?php if ($user_priv->hasPrivilege("Enregistrer absense")) { ?>
                                                    <div class = "tab-pane fade" id = "tab2primary">
                                                        <div class = "box-body">
                                                            <div class = "input-group">
                                                                <span class = "input-group-addon"><i class = "fa fa-question-circle">&nbsp;
                                                                    </i>&nbsp;
                                                                    Motif </span>
                                                                <input type = "text" id = "modifMotif" list = "motifsDefault" class = "form-control" />
                                                            </div>
                                                        </div>
                                                        <button type = "button" class = "btn btn-block btn-danger btn-lg" onclick = "AnnulerSeance()"><i class = "fa fa-ban"></i> Annulé séance <i class = "fa fa-ban"></i></button>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "modal-footer">
                            <button type = "button" class = "btn btn-default" data-dismiss = "modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class = "modal modal-primary fade" id = "addSeance" data-backdrop = "false" tabindex = "-1" role = "dialog" >
                <div class = "modal-dialog">
                    <div class = "modal-content">
                        <div class = "modal-header">
                            <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close"><span aria-hidden = "true">&times;
                                </span></button>
                            <h4 class = "modal-title">Ajouter une séance de cour</h4>
                        </div>
                        <div class = "modal-body">
                            <div class = "box box-info">
                                <div class = "box-body">
                                    <div class = "input-group">
                                        <span class = "input-group-addon"><i class = "fa fa-book">&nbsp;
                                            </i>&nbsp;
                                            Matière </span>
                                        <select class = "form-control matiereSelect" id = "addMatiere">

                                        </select>
                                    </div>
                                    <br>
                                    <div class = "input-group">
                                        <span class = "input-group-addon"><i class = "fa fa-clock-o">&nbsp;
                                            </i>&nbsp;
                                            Date et heure de la séance</span>
                                        <input type = "text" id = "seance" name = "seanceIntervalle" class = "form-control" >
                                    </div>
                                    <br>
                                    <div class = "input-group">
                                        <span class = "input-group-addon"><i class = "fa fa-map-marker">&nbsp;
                                            </i>&nbsp;
                                            Salle</span>
                                        <select class = "form-control" id = "addSalle">
                                            <option>Salle 1</option>
                                            <option>Salle 2</option>
                                            <option>Salle 3</option>
                                            <option>Salle 4</option>
                                            <option>Salle 5</option>
                                            <option>Info 1</option>
                                            <option>Info 2</option>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" name="etat" class="checkbox-inline icheck" id="addEtat">&nbsp; Seance annulé
                                        </span>
                                        <input type="text" id="addMotif"  list="motifsDefault" class="form-control" disabled>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" class="checkbox-inline icheck" name="etat" id="addRetard">&nbsp; Seance avec Retard
                                        </span>
                                        <select class="form-control" id="addRetardDuree"  disabled>
                                            <option>5</option>
                                            <option>10</option>
                                            <option>15</option>
                                            <option>20</option>
                                            <option>25</option>
                                            <option>30</option>
                                            <option>35</option>
                                            <option>40</option>
                                            <option>45</option>
                                            <option>50</option>
                                            <option>55</option>
                                            <option>60</option>
                                        </select>
                                        <span class="input-group-addon"><i class="fa fa-clock-o">&nbsp;</i>&nbsp;Min</span>
                                    </div>
                                    <br>
                                    <button type="button" class="btn btn-block btn-primary btn-lg" onclick="AjouterSeance(document.getElementById('addEtat').checked, document.getElementById('addRetard').checked, $('#addRetardDuree option:selected').text(), $('#addMotif').val(), $('#addMatiere').val(), $('#addSalle option:selected').text())"><i class="fa fa-calendar-plus-o"></i> Ajouter séance <i class="fa fa-calendar-plus-o"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
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
                    <section class="content-header">
                        <h1>
                            Séances de cours
                        </h1>
                    </section>

                    <!-- Main content -->
                    <section class="content">
                        <div class="row">
                                <div class="box box-primary">
                                    <div class="box-body no-padding" >
                                        <div class="form-group col-md-4">
                                            <label>Filière : </label>
                                            <div class="input-group input-lg">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-graduation-cap"></i>
                                                </div>
                                                <select class="form-control" id="filiereId">
                                                    <?php foreach ($filieres as $filiere): ?>
                                                        <option value="<?= $filiere->id ?>"><?= $filiere->nom_filiere ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3" style="border-left:1px dashed #3c8dbc;">
                                            <label>Semestre : </label>
                                            <div class="input-group input-lg">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-book"></i>
                                                </div>
                                                <select class="form-control" id="semestreId" >
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4" style="border-left:1px dashed #3c8dbc;">
                                            <label>Navigation rapide : </label>
                                            <div class="input-group input-lg">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" id="dateSearch" class="form-control" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask=""/>
                                                <span class="input-group-btn" >
                                                        <button type="button" onclick="moveCalendarTo(document.getElementById('dateSearch').value)" class="btn btn-info">Go ! </button>
                                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                          <span class="caret"></span>
                                                          <span class="sr-only">Afficher le menu</span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="#" id="MoveToDebut">Début du semestre</a></li>
                                                            <li><a href="#" id="MoveToEnd">Fin du semestre</a></li>
                                                        </ul>
                                                    <!-- <div class="btn-group-justified" role="group" >
                                                        <button  type="button" class="btn btn-info btn-flat">Go!</button>
                                                        <button onclick="moveCalendarToStart()" type="button" class="btn btn-info btn-flat">Début</button>
                                                        <button onclick="moveCalendarToEnd()" type="button" class="btn btn-info btn-flat">Fin</button>
                                                    </div>-->
                                                </span>
                                            </div>
                                        </div>
                                        <div id="calendar"></div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /. box -->
                        </div>
                        <!-- /.row -->
                    </section>
                    <!-- /.content -->
                </div>
                <!-- /.content-wrapper -->

                <!-- Main Footer -->
                <?php include 'includes/footer.php'; ?>
            </div>
            <script src="Views/plugins/iCheck/icheck.min.js"></script>
            <script src="Views/bootstrap/js/bootstrap.min.js"></script>
            <script src="Views/dist/js/app.min.js"></script>
            <script src="Views/dist/js/demo.js"></script>
            <script src="Views/Full Cal/moment.min.js" type="text/javascript"></script>
            <script src="Views/Full Cal/fullcalendar.js" type="text/javascript"></script>
            <script src="Views/plugins/daterangepicker/daterangepicker.js"></script>
            <script src="Views/plugins/input-mask/jquery.inputmask.js"></script>
            <script src="Views/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
            <script src="Views/plugins/notify.min.js" type="text/javascript"></script>
            <script src="Views/plugins/datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
            <script src="Views/plugins/datetimepicker/bootstrap-datetimepicker.fr.js" type="text/javascript"></script>
            <script src="Views/plugins/datatables/jquery.dataTables.min.js"></script>
            <script src="Views/plugins/datatables/dataTables.bootstrap.min.js"></script>
            <script src="Views/personnalJs/Utils.js" type="text/javascript"></script>
            <!-- Optionally, you can add Slimscroll and FastClick plugins.
                 Both of these plugins are recommended to enhance the
                 user experience. Slimscroll is required when using the
                 fixed layout. -->
            <script>
                                                            var EventModif;
                                                            var addStart;
                                                            var addEnd;
                                                            var selectedFeed;
                                                            var restrictionDebutFiliere,restrictionFinFiliere;
                                                            
                                                            $("#MoveToDebut").click(function (e) {
                                                                    e.preventDefault();
                                                                    $.post("AjaxProcess/GestionCalendrierCours/GetSemestreDateDebut.php", {semestreParam: $('#semestreId').val()}, function (data, status) {
                                                                        moveCalendarTo(data);
                                                                    });
                                                                });
                                                                
                                                            $("#MoveToEnd").click(function (e) {
                                                                    e.preventDefault();
                                                                    $.post("AjaxProcess/GestionCalendrierCours/GetSemestreDateFin.php", {semestreParam: $('#semestreId').val()}, function (data, status) {
                                                                        moveCalendarTo(data);
                                                                    });
                                                                });
                                                                
                                                            $("#filiereId").change(function () {
                                                                $.post("AjaxProcess/GestionCalendrierCours/GetFiliereSemestres.php", {filiereParam: $(this).val()}, function (data, status) {
                                                                    $("#semestreId").empty();
                                                                    data.forEach(function (obj) {
                                                                        $("#semestreId").append("<option data-feed='AjaxProcess/GetEvents.php?semestreParam=" + obj.id + "&type=0' value='" + obj.id + "'>" + obj.nomSemestre + "</option>");
                                                                    });
                                                                    $('#semestreId').change();
                                                                });
                                                                $.post("AjaxProcess/GestionCalendrierCours/restrictionFiliere.php",{idFilere:$(this).val()},function(data,status){
                                                                    restrictionDebutFiliere = data.date_debut;
                                                                    restrictionFinFiliere = data.date_expiration;
                                                                });
                                                            });
                                                            
                                                            function onSelectChangeFeed() {
                                                                var feed = $(this).find(':selected').data('feed');
                                                                $('#calendar').fullCalendar('removeEventSource', selectedFeed);
                                                                $('#calendar').fullCalendar('addEventSource', feed);
                                                                selectedFeed = feed;
                                                                $.post("AjaxProcess/GestionCalendrierCours/GetSemestreMatieres.php", {semestreParam: $('#semestreId').val()}, function (data, status) {
                                                                    $(".matiereSelect").empty();
                                                                    data.forEach(function (obj) {
                                                                        $(".matiereSelect").append("<option value='" + obj.id + "'>" + obj.nom + "</option>");
                                                                    });
                                                                });
                                                                    
                                                            }
                                                            function compareTime(mnt, deb,fin) {
                                                                if (deb == null || deb == '' || fin == null || fin == '') {
                                                                    return true;
                                                                } else {
                                                                    var bol= new Date(mnt) < new Date(deb) || new Date(mnt) > new Date(fin);
                                                                    return bol;
                                                                }
                                                            }
                                                            
                                                            $(document).ready(function () {
                                                                $('#semestreId').change(onSelectChangeFeed);
                                                                $("#filiereId").change();
                                                                $('#calendar').fullCalendar({
                                                                    columnFormat: {
                                                                        month: 'dddd',
                                                                        week: 'dddd, MMM dd',
                                                                        day: 'dddd, MMM dd'
                                                                    },
                                                                    defaultEventMinutes: 120,
                                                                    axisFormat: 'HH:mm',
                                                                    timeFormat: {
                                                                        agenda: 'H:mm{ - h:mm}'
                                                                    },
                                                                    dragOpacity: {
                                                                        agenda: .9
                                                                    },
                                                                    allDaySlot: false,
                                                                    minTime: 0,
                                                                    maxTime: 24,
                                                                    selectOverlap: false,
                                                                    minTime: "07:00:00",
                                                                    maxTime: "19:00:00",
                                                                    height: $(document).height() - 100,
                                                                    theme: false,
                                                                    allDayText: "Jour Complet",
                                                                    firstHour: 10,
                                                                    editable: false,
                                                                    selectable: true,
                                                                    lastHour: 18,
                                                                    eventRender: function (event, element) {
                                                                        element.mouseenter(function () {
                                                                            $(this).addClass("animated pulse");
                                                                        }).mouseleave(function () {
                                                                            $(this).removeClass("animated pulse");
                                                                        });
                                                                        element.find(".fc-event-head").append("<i class='fa fa-remove'></i> &nbsp; <i class='fa fa-edit'></i>");
                                                                        element.click(function () {
                                                                            EventModif = event;
                                                                            var t = $('#tableIntervenants').DataTable();
                                                                            t.clear();
                                                                            $("#infoMatiere").text(EventModif.title);
                                                                            $("#infoRangeDate").text($.fullCalendar.formatDate(EventModif.start, 'yyyy/MM/dd HH:mm') + ' -  ' + $.fullCalendar.formatDate(EventModif.end, 'HH:mm'));
                                                                            $('#ModifDebutseance').val($.fullCalendar.formatDate(EventModif.start, 'yyyy/MM/dd HH:mm:ss'));
                                                                            $('#ModifFinseance').val($.fullCalendar.formatDate(EventModif.end, 'yyyy/MM/dd HH:mm:ss'));
                                                                            $.post("AjaxProcess/GestionCalendrierCours/FullInfo.php", {id: event.id}, function (data, status) {
                                                                                if (data.intervenants.constructor === Array) {
                                                                                    for (var i = 0; i < data.intervenants.length; i++) {
                                                                                        var obj = data.intervenants[i];
                                                                                        t.row.add([
                                                                                            obj.civilite,
                                                                                            obj.email
                                                                                        ]).draw(false);
                                                                                    }
                                                                                } else {
                                                                                    t.row.add([
                                                                                        data.intervenants.civilite,
                                                                                        data.intervenants.email
                                                                                    ]).draw(false);
                                                                                }
                                                                                $("#infoProf").text(data.user_name);
                                                                                $("#infoEtat").text(event.etat);
                                                                                $('#infoRetard').text('');
                                                                                 $('#infoMotif').text('');
                                                                                if (event.etat == "annulé") {
                                                                                    $("#infoMotif").text(event.motif);
                                                                                }else if (event.etat == "retard") {
                                                                                    $("#infoRetard").text(event.retard);
                                                                                }
                                                                            });
                                                                            $('#CRUDmodal').modal('show');
                                                                        });
                                                                        if (event.etat === "annulé") {
                                                                            element.css({"border": "1.5px solid red"});
                                                                            element.tooltip({title: event.motif, placement: "top"});
                                                                            element.find(".fc-event-head").append("&nbsp;&nbsp;Seance Annulé");
                                                                        } else if (event.etat === "retard") {
                                                                            element.css({"border": "1.5px solid orange"});
                                                                            element.tooltip({title: "retard de " + event.retard + " min", placement: "top"});
                                                                            element.find(".fc-event-head").append("&nbsp;&nbsp;Seance avec un Retard de " + event.retard);
                                                                        }
                                                                    },
                                                                    header: {
                                                                        left: 'prev,next today',
                                                                        center: 'title',
                                                                        right: 'month,agendaWeek,agendaDay'
                                                                    },
                                                                    defaultView: 'month',
                                                                    buttonText: {
                                                                        today: 'aujourd\'hui',
                                                                        month: 'mois',
                                                                        week: 'semaines',
                                                                        day: 'jours'
                                                                    },
                                                                    lazyFetching: true,
                                                                    slotMinutes: 15,
                                                                    monthNames: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
                                                                    monthNamesShort: ["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Jul", "Aou", "Sep", "Oct", "Nov", "Déc"],
                                                                    dayNames: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],
                                                                    dayNamesShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"],
                                                                    eventSources: [selectedFeed]
                                                                    , select: function (start, end, allDay) {
                                                                        var endtime = $.fullCalendar.formatDate(end, 'h:mm tt');
                                                                        var starttime = $.fullCalendar.formatDate(start, 'h:mm tt');
                                                                        addStart = $.fullCalendar.formatDate(start, 'yyyy-MM-dd HH:mm:ss');
                                                                        addEnd = $.fullCalendar.formatDate(end, 'yyyy-MM-dd HH:mm:ss');
                                                                        if( compareTime(addStart,restrictionDebutFiliere,restrictionFinFiliere)){
                                                                                var mywhen = starttime + ' - ' + endtime;
                                                                                var view = $('#calendar').fullCalendar('getView').name;
                                                                                if (view === "agendaDay" || view === "agendaWeek") {
                                                                                    $('#addSeance #seance').val(mywhen);
                                                                                    $('#addSeance').modal('show');
                                                                                } else {
                                                                                    $('#calendar').fullCalendar('changeView', 'agendaDay');
                                                                                    moveCalendarTo(addStart);
                                                                                }
                                                                        }else{
                                                                            displayNotification("l'administrateur a appliquer une restriction pour cette période","danger");
                                                                        }
                                                                    }
                                                                });
                                                                
                                                                $("#datemask").inputmask("mm/dd/yyyy", {"placeholder": "dd/mm/yyyy"});
                                                                $("[data-mask]").inputmask();

                                                                $('#addEtat').on('ifChecked', function () {
                                                                    document.getElementById('addMotif').disabled = false;
                                                                    $('#addRetard').iCheck('uncheck');
                                                                });
                                                                $('#addEtat').on('ifUnchecked', function () {
                                                                    document.getElementById('addMotif').disabled = true;
                                                                });
                                                                $('#addRetard').on('ifUnchecked', function () {
                                                                    document.getElementById('addRetardDuree').disabled = true;
                                                                });
                                                                $('#addRetard').on('ifChecked', function () {
                                                                    $('#addEtat').iCheck('uncheck');
                                                                    document.getElementById('addRetardDuree').disabled = false;
                                                                });
                                                                $('.icheck').iCheck({
                                                                    checkboxClass: 'icheckbox_square-red',
                                                                    increaseArea: '20%'
                                                                });
                                                                $(".ModifPicker").datetimepicker({
                                                                    minuteStep: 15,
                                                                    format: 'yyyy-mm-dd hh:ii:ss',
                                                                    hourMin: 7,
                                                                    hourMax: 20,
                                                                    language: 'fr'
                                                                });
                                                                $('#ModifDebutseance').datetimepicker().on('changeDate', function (ev) {
                                                                    $('#ModifFinseance').datetimepicker('setStartDate', ev.date);
                                                                });
                                                                $('#tableIntervenants').DataTable(DataTableParams);
                                                            });
                                                            function moveCalendarTo(date) {
                                                                var toDate = new Date(date);
                                                                $('#calendar').fullCalendar('gotoDate', toDate);
                                                            }

                                                            function AjouterSeance(Estannule, Estenretard, dureeRetard, motif, id_matiere, salle) {
                                                                if (id_matiere == '' || id_matiere == null) {
                                                                    $('#addMatiere').addClass("errors");
                                                                    displayNotification('Seance ', 'error');
                                                                } else {
                                                                    $.post("AjaxProcess/GestionCalendrierCours/addEvent.php", {date_debut: addStart, date_fin: addEnd, type: '0', annule: Estannule, retard: Estenretard, dureeRetard: dureeRetard, motif: motif, id_matiere: id_matiere, id_salle: salle}, function (data, status) {
                                                                        if (!isNaN(parseInt(data))) {
                                                                            $('#calendar').fullCalendar('refetchEvents');
                                                                            displayNotification('Seance Ajouté avec succés', 'success');
                                                                            $('#addSeance').modal('hide');
                                                                        } else {
                                                                            displayNotification(data, 'danger',8000);
                                                                        }
                                                                    });
                                                                }
                                                            }
    <?php if ($user_priv->hasPrivilege("Enregistrer absense")) { ?>
                                                                function AnnulerSeance() {
                                                                    var mot = $("#modifMotif").val();
                                                                    var annulerStart = $.fullCalendar.formatDate(EventModif.start, 'yyyy-MM-dd HH:mm:ss');
                                                                    $.post("AjaxProcess/GestionCalendrierCours/AnnulerEvent.php", {motif: mot, EventStart: annulerStart, id: EventModif.id}, function (data, status) {
                                                                        console.log(data);
                                                                        if (parseInt(data) >= 1) {
                                                                            EventModif.etat = "annulé";
                                                                            EventModif.motif = mot;
                                                                            $('#calendar').fullCalendar('updateEvent', EventModif);
                                                                            $('#CRUDmodal').modal('hide');
                                                                            displayNotification('Séance annulé avec succés', 'success');
                                                                        }
                                                                    });
                                                                }
    <?php
    }
    if ($user_priv->hasPrivilege("Modifier état avancement")) {
        ?>
                                                                function ModifierSeance() {
                                                                    var start = $('#ModifDebutseance').val();
                                                                    var end = $('#ModifFinseance').val();
                                                                    $('#ModifDebutseance').removeClass("errors");
                                                                    $('#ModifFinseance').removeClass("errors");
                                                                    if (start == null || start == '') {
                                                                        $('#ModifDebutseance').addClass("errors");
                                                                    } else {
                                                                        if (end == null || end == '') {
                                                                            $('#ModifFinseance').addClass("errors");
                                                                        } else {
                                                                            $.post("AjaxProcess/GestionCalendrierCours/ModifierSeance.php", {id: EventModif.id, start: $('#ModifDebutseance').val(), end: $('#ModifFinseance').val(), matiere: $("#matiereModif").val()}, function (data, status) {
                                                                                console.log(data);
                                                                                if (parseInt(data) >= 1) {
                                                                                    $('#calendar').fullCalendar('removeEventSource', selectedFeed);
                                                                                    $('#calendar').fullCalendar('addEventSource', selectedFeed);
                                                                                    $('#CRUDmodal').modal('hide');
                                                                                    displayNotification('Séance Modifié avec succés', 'success');
                                                                                }
                                                                            });
                                                                        }
                                                                    }
                                                                }
    <?php } ?>
    <?php if ($user_priv->hasPrivilege("Supprimer état avancement")) { ?>
                                                                function SupprimerSeance() {
                                                                    var result = confirm("Etes-vous sure de vouloir supprimer cette séance ?");
                                                                    if (result) {
                                                                        $.post("AjaxProcess/GestionCalendrierCours/SupprimerSeance.php", {id: EventModif.id}, function (data, status) {
                                                                            if (parseInt(data) >= 1) {
                                                                                $('#calendar').fullCalendar('removeEventSource', selectedFeed);
                                                                                $('#calendar').fullCalendar('addEventSource', selectedFeed);
                                                                                $('#CRUDmodal').modal('hide');
                                                                                displayNotification('Séance Supprimé avec succés', 'success');
                                                                            }
                                                                        });
                                                                    }
                                                                }
        <?php
    }
    if ($user_priv->hasPrivilege("Enregistrer retard")) {
        ?>
                                                                function EnregistrerRetard(duree) {
                                                                    $.post("AjaxProcess/GestionCalendrierCours/addRetard.php", {id: EventModif.id, retard: duree}, function (data, status) {
                                                                        if (parseInt(data) === 1) {
                                                                            EventModif.etat = "retard";
                                                                            EventModif.retard = duree;
                                                                            $('#calendar').fullCalendar('updateEvent', EventModif);
                                                                            $('#CRUDmodal').modal('hide');
                                                                            displayNotification('Retard ajouté ! ', 'success');
                                                                        } else {
                                                                            displayNotification(data, 'danger');
                                                                        }
                                                                    });
                                                                }
    <?php } ?>

                                                            $(document).ajaxStart(function () {
                                                                $.LoadingOverlay("show", {
                                                                    image: "",
                                                                    fontawesome: "fa fa-hourglass-start fa-spin"
                                                                });
                                                            });
                                                            $(document).ajaxStop(function () {
                                                                $.LoadingOverlay("hide");
                                                            }
                                                            );
            </script>
        <?php
        } else {
            include 'includes/AccessDenied.php';
        }
        ?>
    </body>
</html>
