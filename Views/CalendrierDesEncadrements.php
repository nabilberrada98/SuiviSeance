 
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->

<?php
$controller = new CalendrierDesCoursController();
$profs = $controller->getAllProffeseurs();
$filieres = $controller->getAllFilieres();
$salles = $controller->getAllSalles();
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
        <link rel="icon" type="image/png" href="Views/dist/img/logo.png" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Calendrier des séances d'encadrements</title>
        <!-- Tell the browser to be responsive to screen width -->
        <script src="Views/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="Views/dist/js/loadingoverlay.min.js" type="text/javascript"></script>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="Views/plugins/iCheck/square/red.css">
        <link rel="stylesheet" href="Views/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="Views/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="Views/plugins/daterangepicker/daterangepicker.css">
        <link rel="stylesheet" href="Views/dist/css/skins/skin-blue.min.css">
        <link href="Views/Full Cal/fullcalendar.css" rel="stylesheet" type="text/css"/>
        <link href="Views/Full Cal/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        <link href="Views/plugins/datetimepicker/datetimepicker.css" rel="stylesheet" type="text/css"/>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <style>
            .take-all-space-you-can{
                width:33.33%;
            }
        </style>
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <datalist id="motifsDefault">
            <option value="Profeseur Malade">
            <option value="Anulation de la direction">    
        </datalist>
        <?php
        if (isset($googleId) && !empty($googleId)) {
            ?>
            <div class="modal modal-primary fade" id="CRUDmodal" data-backdrop="false" tabindex="-1" role="dialog" >
                <div class="modal-dialog">
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
                                                <li class="take-all-space-you-can active"><a href="#tab1primary" data-toggle="tab"><Center><i class="fa fa-info-circle"></i>&nbsp; Information &nbsp; <i class="fa fa-info-circle"></i></Center></a></li>
                                                <li class="take-all-space-you-can"><a href="#tab2primary" data-toggle="tab"><Center><i class="fa fa-edit"></i>&nbsp; Modifier &nbsp; <i class="fa fa-edit"></i></Center></a></li>
                                                <li class="take-all-space-you-can"><a href="#tab3primary" data-toggle="tab"><Center><i class="fa fa-trash"></i>&nbsp; Annulé &nbsp; <i class="fa fa-trash"></i></Center></a></li>
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
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="tab2primary">
                                                    <div class="box-body">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-book">&nbsp;</i>&nbsp;Matière : </span>
                                                            <select class="form-control matiereSelect" id="matiereModif">
                                                            </select>
                                                        </div>
                                                        <br>
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
                                                <div class="tab-pane fade" id="tab3primary">
                                                    <div class="box-body">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-question-circle">&nbsp;</i>&nbsp;Motif </span>
                                                            <input type="text" id="modifMotif" list="motifsDefault" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-block btn-danger btn-lg" onclick="AnnulerSeance()"><i class="fa fa-ban"></i> Annulé séance <i class="fa fa-ban"></i></button>
                                                </div>
                                            </div>
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

            <div class="modal modal-primary fade" id="addSeance" data-backdrop="false" tabindex="-1" role="dialog" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Ajouter une séance de cour</h4>
                        </div>
                        <div class="modal-body">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="input-group">
                                        <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                                            <ul class="fc-color-picker" id="color-chooser">
                                                <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
                                                <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
                                                <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
                                                <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
                                                <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
                                                <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
                                                <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
                                                <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
                                                <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
                                                <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
                                                <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
                                                <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
                                                <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
                                                <li><a class="text-maroon" href="#"><i class="fa fa-square"></i></a></li>
                                                <li><a class="text-danger" href="#"><i class="fa fa-square"></i></a></li>
                                                <li><a class="text-olive" href="#"><i class="fa fa-square"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-book">&nbsp;</i>&nbsp;Matière </span>
                                        <select class="form-control matiereSelect" id="addMatiere">
                                        </select>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-clock-o">&nbsp;</i>&nbsp;Date et heure de la séance</span>
                                        <input type="text" id="seance" name="seanceIntervalle" class="form-control" >
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-map-marker">&nbsp;</i>&nbsp;Salle</span>
                                        <select class="form-control" id="addSalle">
                                            <?php foreach ($salles as $salle): ?>
                                                <option value="<?= $salle->id ?>"><?= $salle->id ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" class="checkbox-inline" id="addEtat">&nbsp; Seance annulé
                                        </span>
                                        <input type="text" id="addMotif" list="motifsDefault" class="form-control" disabled>
                                    </div>
                                    <br>
                                    <button type="button" class="btn btn-block btn-primary btn-lg" onclick="AjouterSeance(document.getElementById('addEtat').checked, $('#addMotif').val(), $('#addMatiere').val(), $('#addSalle').val())"><i class="fa fa-calendar-plus-o"></i> Ajouter séance <i class="fa fa-calendar-plus-o"></i></button>
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
                            Seances de cours
                        </h1>
                    </section>

                    <!-- Main content -->
                    <section class="content">
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-body no-padding" >
                                        <div class="form-group col-md-4" >
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
                                        <div class="form-group col-md-3" style="border-left:1px dashed #3c8dbc;">
                                            <label>Navigation rapide : </label>
                                            <div class="input-group input-lg">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" id="dateSearch" class="form-control" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask=""/>
                                                <span class="input-group-btn" >
                                                    <button onclick="moveCalendarTo(document.getElementById('dateSearch').value)" type="button" class="btn btn-info btn-flat">Go!</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div id="loading"></div>
                                        <div id="calendar"></div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /. box -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </section>
                    <!-- /.content -->
                </div>
                <!-- /.content-wrapper -->

                <!-- Main Footer -->
                <?php include 'includes/footer.php'; ?>
            </div>
        <?php } else { ?>
            <div class="modal modal-danger" style="display: block;">
                <div class="modal-dialog" >
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Erreur</h4>
                        </div>
                        <div class="modal-body">
                            <p>Vous devez vous connecter pour accéder a ce contenu.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Fermer</button>
                            <a style="text-decoration: none; color: white;" href="login"><button type="button" class="btn btn-outline">Se Connecter </button></a>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        <?php } ?>
        <link href="Views/dist/css/animate.css" rel="stylesheet" type="text/css"/>
        <script src="Views/plugins/iCheck/icheck.min.js"></script>
        <script src="Views/bootstrap/js/bootstrap.min.js"></script>
        <script src="Views/dist/js/app.min.js"></script>
        <script src="Views/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="Views/plugins/fastclick/fastclick.js"></script>
        <script src="Views/dist/js/demo.js"></script>
        <script src="Views/Full Cal/moment.min.js" type="text/javascript"></script>
        <script src="Views/Full Cal/fullcalendar.js" type="text/javascript"></script>
        <script src="Views/plugins/daterangepicker/daterangepicker.js"></script>
        <script src="Views/plugins/select2/select2.full.min.js"></script>
        <script src="Views/plugins/input-mask/jquery.inputmask.js"></script>
        <script src="Views/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
        <script src="Views/plugins/notify.min.js" type="text/javascript"></script>
        <script src="Views/plugins/datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
        <script src="Views/plugins/datetimepicker/bootstrap-datetimepicker.fr.js" type="text/javascript"></script>
        <style>
            .errors{
                border: 0;
                border-bottom: 1px solid red;
                outline: 0;
            }
        </style>
        <!-- Optionally, you can add Slimscroll and FastClick plugins.
             Both of these plugins are recommended to enhance the
             user experience. Slimscroll is required when using the
             fixed layout. -->
        <script>
                                                        var EventModif;
                                                        var backcol = "#3c8dbc";
                                                        var metadata = "{\"allDay\" : false, \"backgroundColor\": \"#3c8dbc\", \"borderColor\": \"#3c8dbc\"}";
                                                        var addStart;
                                                        var addEnd;
                                                        var selectedFeed;
                                                        $("#filiereId").change(function () {
                                                            $.post("AjaxProcess/GetFiliereSemestres.php", {filiereParam: $(this).val()}, function (data, status) {
                                                                $("#semestreId").empty();
                                                                data.forEach(function (obj) {
                                                                    $("#semestreId").append("<option data-feed='AjaxProcess/GetEvents.php?semestreParam=" + obj.id + "&type=encadrement' value='" + obj.id + "'>" + obj.id + "</option>");
                                                                });
                                                                $('#semestreId').change();
                                                            });
                                                        });
                                                        function onSelectChangeFeed() {
                                                            var feed = $(this).find(':selected').data('feed');
                                                            console.log("feed " + feed);
                                                            $('#calendar').fullCalendar('removeEventSource', selectedFeed);
                                                            $('#calendar').fullCalendar('addEventSource', feed);
                                                            selectedFeed = feed;
                                                            $.post("AjaxProcess/GetSemestreMatieres.php", {semestreParam: $('#semestreId').val()}, function (data, status) {
                                                                $(".matiereSelect").empty();
                                                                data.forEach(function (obj) {
                                                                    $(".matiereSelect").append("<option value='" + obj.id + "'>" + obj.nom + "</option>");
                                                                });
                                                            });
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
                                                                    agenda: .5
                                                                },
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
                                                                        $("#infoMatiere").text(EventModif.title);
                                                                        $("#infoRangeDate").text($.fullCalendar.formatDate(EventModif.start, 'yyyy/MM/dd HH:mm') + ' -  ' + $.fullCalendar.formatDate(EventModif.end, 'HH:mm'));
                                                                        $('#ModifDebutseance').val($.fullCalendar.formatDate(EventModif.start, 'yyyy/MM/dd HH:mm:ss'));
                                                                        $('#ModifFinseance').val($.fullCalendar.formatDate(EventModif.end, 'yyyy/MM/dd HH:mm:ss'));
                                                                        $.post("AjaxProcess/FullInfo.php", {id: EventModif.id}, function (data, status) {
                                                                            $("#infoProf").text(data.user_name);
                                                                            $("#infoEtat").text(data.etat);
                                                                            if (data.motif != "" && data.motif != null) {
                                                                                $("#infoMotif").text(data.motif);
                                                                            } else {
                                                                                $("#infoMotif").prop('disabled', true);
                                                                            }
                                                                        });
                                                                        $('#CRUDmodal').modal('show');
                                                                    });
                                                                    if (event.etat === "annulé") {
                                                                        element.css({"border": "1.3px solid red"});
                                                                        element.tooltip({title: event.motif, placement: "top"});
                                                                        element.find(".fc-event-head").append("&nbsp;&nbsp;Seance Annulé");
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
                                                                    var mywhen = starttime + ' - ' + endtime;
                                                                    var view = $('#calendar').fullCalendar('getView').name;
                                                                    if (view === "agendaDay" || view === "agendaWeek") {
                                                                        $('#addSeance #seance').val(mywhen);
                                                                        $('#addSeance').modal('show');
                                                                    } else {
                                                                        $('#calendar').fullCalendar('changeView', 'agendaDay');
                                                                        moveCalendarTo(addStart);
                                                                    }
                                                                }
                                                            });

                                                            $("#datemask").inputmask("mm/dd/yyyy", {"placeholder": "dd/mm/yyyy"});
                                                            $("[data-mask]").inputmask();
                                                            $('#addEtat').on('ifChecked', function () {
                                                                document.getElementById('addMotif').disabled = false;
                                                            });
                                                            $('#addEtat').on('ifUnchecked', function () {
                                                                document.getElementById('addMotif').disabled = true;
                                                            });
                                                            $('#addEtat').iCheck({
                                                                checkboxClass: 'icheckbox_square-red',
                                                                increaseArea: '20%' // optional
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
                                                        });
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
                                                        var colorChooser = $("#color-chooser-btn");
                                                        $("#color-chooser > li > a").click(function (e) {
                                                            e.preventDefault();
                                                            backcol = $(this).css("color");
                                                            metadata = "{ \"allDay\" : false, \"backgroundColor\": \"" + rgb2hex(backcol.toString()) + "\", \"borderColor\": \"" + rgb2hex(backcol.toString()) + "\"}";
                                                            $('#addSeance .box-body').css({"background-color": backcol, "border-color": backcol, "color": "#FFFFFF"});
                                                        });
                                                        function moveCalendarTo(date) {
                                                            var toDate = new Date(date);
                                                            $('#calendar').fullCalendar('gotoDate', toDate);
                                                        }
                                                        function rgb2hex(rgb) {
                                                            rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
                                                            return (rgb && rgb.length === 4) ? "#" +
                                                                    ("0" + parseInt(rgb[1], 10).toString(16)).slice(-2) +
                                                                    ("0" + parseInt(rgb[2], 10).toString(16)).slice(-2) +
                                                                    ("0" + parseInt(rgb[3], 10).toString(16)).slice(-2) : '';
                                                        }
                                                        function AjouterSeance(etat, motif, id_matiere, id_salle) {
                                                            if (id_matiere == '' || id_matiere == null) {
                                                                $('#addMatiere').addClass("errors");
                                                                displayNotification('Seance ', 'error');
                                                            } else {
                                                                $.post("AjaxProcess/addEvent.php", {date_debut: addStart, date_fin: addEnd, type: 'false', etat: etat, motif: motif, metadata: metadata, id_matiere: id_matiere, id_salle: id_salle}, function (data, status) {
                                                                    if (!isNaN(parseInt(data))) {
                                                                        $('#calendar').fullCalendar('refetchEvents');
                                                                        displayNotification('Seance Ajouté avec succés', 'success');
                                                                        $('#addSeance').modal('hide');
                                                                    } else {
                                                                        displayNotification('Oups ! une érreur s\'est produite', 'danger');
                                                                    }
                                                                });
                                                            }
                                                        }

                                                        function AnnulerSeance() {
                                                            var mot = $("#modifMotif").val();
                                                            var annulerStart = $.fullCalendar.formatDate(EventModif.start, 'yyyy-MM-dd HH:mm:ss');
                                                            $.post("AjaxProcess/AnnulerEvent.php", {motif: mot, EventStart: annulerStart, id: EventModif.id}, function (data, status) {
                                                                if (parseInt(data) >= 1) {
                                                                    EventModif.etat = "annulé";
                                                                    EventModif.motif = mot;
                                                                    $('#calendar').fullCalendar('updateEvent', EventModif);
                                                                    $('#CRUDmodal').modal('hide');
                                                                    displayNotification('Seance annulé', 'success');
                                                                }
                                                            });
                                                        }
                                                        
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
                                                                    $.post("AjaxProcess/ModifierSeance.php", {id: EventModif.id, start: $('#ModifDebutseance').val(), end: $('#ModifFinseance').val(), matiere: $("#matiereModif").val()}, function (data, status) {
                                                                        console.log(data);
                                                                        if (parseInt(data) >= 1) {
                                                                            $('#calendar').fullCalendar('updateEvent', EventModif);
                                                                            $('#calendar').fullCalendar('refresh');
                                                                            $('#CRUDmodal').modal('hide');
                                                                            displayNotification('Séance Modifié', 'success');
                                                                        }
                                                                    });
                                                                }
                                                            }
                                                        }
                                                        
                                                        $(document).ajaxStart(function () {
                                                            $.LoadingOverlay("show", {
                                                                image: "",
                                                                fontawesome: "fa fa-hourglass-start fa-spin"
                                                            });
                                                        });
                                                        $(document).ajaxStop(function () {
                                                            $.LoadingOverlay("hide");
                                                        });
        </script>
    </body>
</html>
