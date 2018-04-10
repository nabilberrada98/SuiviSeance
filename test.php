<?php ?>


<br>  
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-graduation-cap">&nbsp;</i>&nbsp;Professeur</span>
    <select class="form-control" id="addProf">
        <?php foreach ($profs as $prof): ?>
            <option value="<?= $prof->id ?>"><?= $prof->prenom . ' ' . $prof->nom ?></option>
        <?php endforeach; ?>
    </select>
    <?php foreach ($matieres as $matiere): ?>
        <option value="<?= $matiere->id ?>"><?= $matiere->nom ?></option>
    <?php endforeach; ?>


    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-graduation-cap">&nbsp;</i>&nbsp;Professeur</span>
        <select class="form-control" id="profModif">
            <?php foreach ($profs as $prof): ?>
                <option value="<?= $prof->user_id ?>"><?= $prof->user_name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<?php
header('Content-Type: application/json');
require_once '../Entity/MatiereEntity.php';
require_once '../classes/Database.php';
require_once '../classes/Config.php';
require_once '../Controllers/Controller.php';
require_once '../Controllers/CalendrierController.php';
$groupe = $_POST['filiereParam'];
$controller = new CalendrierController();
$matieres = $controller->getAllMatieres($groupe);
echo json_encode($matieres);
exit;
?>


events: {
url: 'AjaxProcess/GetEvents.php',
type: 'POST',
data:{  // a function that returns an object
groupeParam: $("#groupeId").val()
},
error: function () {
alert('Oups , une érreur s\'est produite lors du chargements des séances !');
}
}
/* [
{
title: 'All Day Event',
start: new Date(y, m, 1),
backgroundColor: "#f56954", //red
borderColor: "#f56954"
//red
},
{
title: 'Long Event',
start: new Date(y, m, d - 5),
end: new Date(y, m, d - 2),
backgroundColor: "#f39c12", //yellow
borderColor: "#f39c12" //yellow
},
{
title: 'Meeting',
start: new Date(y, m, d, 10, 30),
allDay: false,
backgroundColor: "#0073b7", //Blue
borderColor: "#0073b7",
id: 3,
etat: "annulé",
motif: "mrid l prof wlh zeifu zeuifh zeiufhze oifhz eofhzeio"
},
{
title: 'Birthday Party',
start: new Date(y, m, d + 1, 19, 0),
end: new Date(y, m, d + 1, 22, 30),
allDay: false,
backgroundColor: "#00a65a", //Success (green)
borderColor: "#00a65a" //Success (green)
},
{
title: 'Click for Google',
start: new Date(y, m, 28),
end: new Date(y, m, 29),
url: 'http://google.com/',
backgroundColor: "#3c8dbc", //Primary (light-blue)
borderColor: "#3c8dbc" //Primary (light-blue)
}
]*/


<div class="box box-danger">
    <div class="box-header">
        <h3 class="box-title">Input masks</h3>
    </div>
    <div class="box-body">
        <!-- Date dd/mm/yyyy -->
        <div class="form-group">
            <label>Date masks:</label>

            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
            </div>
            <!-- /.input group -->
            <div class="form-group">
                <label>Date masks:</label>

                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                </div>
                <!-- /.input group -->
                <div class="form-group">
                    <label>Date masks:</label>

                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                    </div>
                    <!-- /.input group -->
                    <div class="form-group">
                        <label>Date masks:</label>

                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                        </div>
                        <!-- /.input group -->
                    </div></div></div></div>
        <!-- /.form group -->

        <!-- Date mm/dd/yyyy -->
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask="">
            </div>
            <!-- /.input group -->
        </div>
        <!-- /.form group -->

        <!-- phone mask -->
        <div class="form-group">
            <label>US phone mask:</label>

            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                </div>
                <input type="text" class="form-control" data-inputmask="&quot;mask&quot;: &quot;(999) 999-9999&quot;" data-mask="">
            </div>
            <!-- /.input group -->
        </div>
        <!-- /.form group -->

        <!-- phone mask -->
        <div class="form-group">
            <label>Intl US phone mask:</label>

            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-phone"></i>
                </div>
                <input type="text" class="form-control" data-inputmask="'mask': ['999-999-9999 [x99999]', '+099 99 99 9999[9]-9999']" data-mask="">
            </div>
            <!-- /.input group -->
        </div>
        <!-- /.form group -->

        <!-- IP mask -->
        <div class="form-group">
            <label>IP mask:</label>

            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-laptop"></i>
                </div>
                <input type="text" class="form-control" data-inputmask="'alias': 'ip'" data-mask="">
            </div>
            <!-- /.input group -->
        </div>
        <!-- /.form group -->

    </div>
    <!-- /.box-body -->
</div>                                    