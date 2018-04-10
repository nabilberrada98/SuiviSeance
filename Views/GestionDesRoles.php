 
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
$roleController = new GestionDesRolesController();
$listUsers = $roleController->getAllUsers();
$listRoles = $roleController->getAllRoles();
$listPermissions = $roleController->getAllPermissions();
?>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="Views/dist/img/logo.png" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Gestion Permissions</title>
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="Views/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="Views/dist/css/skins/skin-blue.min.css">
        <link rel="stylesheet" href="Views/plugins/datatables/dataTables.bootstrap.css">
        <link href="Views/plugins/iCheck/line/blue.css" rel="stylesheet" type="text/css"/>
        <style>
            #mAddRole th,td ,#mModifierRole th,td {
                padding: 5%;
            }
            .errors{
                border: 0;
                border-bottom: 1px solid red;
                outline: 0;
            }
        </style>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <?php
        if (isset($googleId) && !empty($googleId)) {
            ?>

            <div class="modal modal-primary fade" id="mAddRole" data-backdrop="false" tabindex="-1" role="dialog" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Ajouter un Role</h4>
                        </div>
                        <div class="modal-body">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-book"></i> &nbsp; &nbsp; Nom du Role 
                                        </div>
                                        <input type="text" class="form-control" id="roleName">
                                    </div>
                                    <br>
                                    <div class="input-group-addon">
                                        <i class="fa fa-key"></i> &nbsp; &nbsp; Permissions
                                    </div>
                                    <center>
                                        <table>
                                            <?php
                                            for ($index = 0; $index < count($listPermissions); $index++) {
                                                if ($index % 3) {
                                                    echo '<tr>';
                                                }
                                                ?>
                                                <th><input type="checkbox" name="Addpermissions" value="<?= $listPermissions[$index]->perm_id ?>"><label><?= $listPermissions[$index]->perm_desc ?> </label></th>
                                                <?php
                                                if ($index % 3) {
                                                    echo '</tr>';
                                                }
                                            }
                                            ?>
                                        </table>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" onclick="AjouterRole()">Sauvegarder</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal modal-warning fade" id="mModifierRole" data-backdrop="false" tabindex="-1" role="dialog" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Modifier un Role</h4>
                        </div>
                        <div class="modal-body">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-book"></i> &nbsp; &nbsp; Nom du Role 
                                        </div>
                                        <select class="form-control roles" id="ModifRole" onchange="loadPerms(this.value)">
                                            <?php foreach ($listRoles as $role): ?>
                                                <option  value="<?= $role->role_id ?>"><?= utf8_encode($role->role_name) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="input-group-addon">
                                        <i class="fa fa-key"></i> &nbsp; &nbsp; Permissions
                                    </div>
                                    <center>
                                        <table>
                                            <?php
                                            for ($index = 0; $index < count($listPermissions); $index++) {
                                                if ($index % 3) {
                                                    echo '<tr>';
                                                }
                                                ?>
                                                <th><input type="checkbox" name="Modifpermissions" value="<?= $listPermissions[$index]->perm_id ?>"><label><?= $listPermissions[$index]->perm_desc ?> </label></th>
                                                <?php
                                                if ($index % 3) {
                                                    echo '</tr>';
                                                }
                                            }
                                            ?>
                                        </table>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" onclick="ModifierRole()">Sauvegarder</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal modal-danger fade" id="mSupprimerRole" data-backdrop="false" tabindex="-1" role="dialog" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Supprimer un Role</h4>
                        </div>
                        <div class="modal-body">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-book"></i> &nbsp; &nbsp; Nom du Role 
                                        </div>
                                        <select class="form-control roles" id="suppRole">
                                            <?php foreach ($listRoles as $role): ?>
                                                <option value="<?= $role->role_id ?>"><?= utf8_encode($role->role_name) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" onclick="SupprimerRole()">Sauvegarder</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal modal-primary fade" id="mAddUser" data-backdrop="false" tabindex="-1" role="dialog" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Ajouter un Utilisateur</h4>
                        </div>
                        <div class="modal-body">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-book"></i> &nbsp; &nbsp; Nom du Role 
                                        </div>
                                        <select class="form-control roles" id="AddUserRole">
                                            <?php foreach ($listRoles as $role): ?>
                                                <option value="<?= $role->role_id ?>"><?= utf8_encode($role->role_name) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-at"></i> &nbsp; &nbsp; Adresse email a autorisé  
                                        </div>
                                        <input type="email" class="form-control" id="AddUserEmail">
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-phone"></i> &nbsp; &nbsp; Numéro de téléphone  
                                        </div>
                                        <input type="tel" class="form-control" id="AddUserTel">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" onclick="AjouterUser()">Sauvegarder</button>
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
                <div class="content-wrapper" style="min-height: 946px;">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <h1>
                            Gestion des roles & Utilisateurs
                        </h1>
                    </section>
                    <!-- Main content -->
                    <section class="content">
                        <div class="row">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <div class="row">
                                        <div class="panel panel-info col-md-5">
                                            <div class="panel-heading"><i class="fa fa-key"></i>&nbsp; Gestion de roles</div>
                                            <div class="panel-body">
                                                <button type="button" class="btn btn-primary btn-lg fa fa-plus" data-toggle="modal" data-target="#mAddRole">
                                                    Ajouter Role
                                                </button>
                                                <button type="button" class="btn btn-warning btn-lg fa fa-edit" data-toggle="modal" data-target="#mModifierRole" onclick="loadPerms($('#ModifRole').val())">
                                                    Modifier Role
                                                </button>
                                                <button type="button" class="btn btn-danger btn-lg fa fa-trash" data-toggle="modal" data-target="#mSupprimerRole">
                                                    Supprimer Role
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <center> <i class="fa fa-key big-icon" style="font-size: 100px; color: #4cc0f7"></i></center>
                                        </div>
                                        <div class="panel panel-info col-md-5">
                                            <div class="panel-heading"><i class="fa fa-user"></i>&nbsp;Gestion des utilisateurs</div>
                                            <div class="panel-body">
                                                <button type="button" class="btn btn-primary btn-lg fa fa-plus" data-toggle="modal" data-target="#mAddUser">
                                                    Ajouter Utilisateur
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="box-title">Liste des utilisateurs : </h3>
                                </div>
                                <div class="box-body">
                                    <table id="listeusers" class="table table-condensed table-bordered table-hover dataTable" role="grid" aria-describedby="Liste Utilisateurs">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="listeusers" rowspan="1" colspan="1" aria-label="Cliquez pour changer d'ordre">Civilité</th>
                                                <th class="sorting" tabindex="0" aria-controls="listeusers" rowspan="1" colspan="1" aria-label="Cliquez pour changer d'ordre" aria-sort="ascending">Adresse mail</th>
                                                <th class="sorting" tabindex="0" aria-controls="listeusers" rowspan="1" colspan="1" aria-label="Cliquez pour changer d'ordre">Numéro de téléphone</th>
                                                <th class="sorting" tabindex="0" aria-controls="listeusers" rowspan="1" colspan="1" aria-label="Cliquez pour changer d'ordre">Role</th>
                                                <th class="sorting" tabindex="0" aria-controls="listeusers" rowspan="1" colspan="1" aria-label="Cliquez pour changer d'ordre">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($listUsers as $user): ?>
                                                <tr role="row" class="odd">
                                                    <td class=""><img src="<?= $user->user_img_path ?>" class="img-circle" style="width: 25px;"/> &nbsp;&nbsp; <?= ucwords(strtolower($user->user_name)) ?></td>
                                                    <td class="sorting_1"><?= $user->user_email ?></td>
                                                    <td><?= $user->user_phone ?></td>
                                                    <td><?= utf8_encode($user->role_name) ?></td>
                                                    <td><center>
                                                <button onclick="showConfig(<?= $user->role_id ?>)" class="btn btn-primary"><i class="fa fa-cogs"></i></button>
                                                &nbsp;<button class="btn btn-danger" data-btn-ok-label="Oui" data-btn-cancel-label="Non" data-placement="left" data-toggle="confirmation" data-title="Etes vous sure ?"><i class="fa fa-remove"></i></button>
                                                <button onclick="loadUser(<?= $user->user_id ?>)" class="btn btn-warning"><i class="fa fa-edit"></i></button>                                            
                                            </center></td>
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
        <script src="Views/plugins/select2/select2.full.min.js"></script>
        <script src="Views/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="Views/plugins/fastclick/fastclick.js"></script>
        <script src="Views/dist/js/demo.js"></script>
        <script src="Views/plugins/notify.min.js" type="text/javascript"></script>
        <script src="Views/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="Views/plugins/datatables/dataTables.bootstrap.min.js"></script>
        <script src="Views/dist/js/bootstrap-confirmation.min.js" type="text/javascript"></script>
        <!-- Optionally, you can add Slimscroll and FastClick plugins.
             Both of these plugins are recommended to enhance the
             user experience. Slimscroll is required when using the
             fixed layout. -->
        <script>
                                            function validateEmail(email) {
                                                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                                                return re.test(String(email).toLowerCase());
                                            }
                                            function AjouterUser() {
                                                $("#AddUserEmail").removeClass("errors");
                                                if (validateEmail($("#AddUserEmail").val())) {
                                                    $.post("AjaxProcess/GestionRole/AjouterUser.php", {email: $("#AddUserEmail").val(), role: $("#AddUserRole").val(), tel: $("#AddUserTel").val()}, function (data, status) {
                                                        if (data == 'success') {
                                                            displayNotification("Utilisateur ajouté avec succées", "success");
                                                        } else {
                                                            console.log(data);
                                                            displayNotification(data, "error");
                                                        }
                                                    });
                                                } else {
                                                    $("#AddUserEmail").addClass("errors");
                                                }
                                            }
                                            function loadPerms(role) {
                                                $("input:checkbox[name=Modifpermissions]").each(function () {
                                                    $(this).iCheck('uncheck');
                                                });
                                                $.post("AjaxProcess/GestionRole/getPerms.php", {id: role}, function (data, status) {
                                                    var perms = JSON.parse(data);
                                                    if (perms.constructor === Array) {
                                                        for (var i = 0; i < perms.length; i++) {
                                                            $("input:checkbox[name=Modifpermissions][value=" + perms[i].perm_id + "]").iCheck('check');
                                                        }
                                                    } else {
                                                        $("input:checkbox[name=Modifpermissions][value='" + data.perm_id + "']").iCheck('check');
                                                    }
                                                });
//                                                 $("#mModifierRole").show();
                                            }
                                            function displayNotification(text, className) {
                                                $.notify(text, {
                                                    clickToHide: true,
                                                    autoHide: true,
                                                    autoHideDelay: 3000,
                                                    arrowShow: true,
                                                    arrowSize: 50,
                                                    className: className,
                                                    gap: 120
                                                });
                                            }

                                            function SupprimerRole() {
                                                var role = $("#suppRole").val();
                                                $.post("AjaxProcess/GestionRole/SupprimerRole.php", {idRole: role}, function (data, status) {
                                                    if (parseInt(data) === 1) { 
                                                        $(".roles option[value='" + role + "']").remove();
                                                        $("#mSupprimerRole").hide();
                                                        displayNotification("Role supprimé avec succés", "success");
                                                    } else {
                                                        displayNotification(data, "danger");
                                                    }
                                                });
                                            }
                                            function AjouterRole() {
                                                $("#roleName").removeClass("errors");
                                                if ($("#roleName").val() != null && $("#roleName").val() != '') {
                                                    var array = [];
                                                    $("input:checkbox[name=Addpermissions]:checked").each(function () {
                                                        array.push($(this).val());
                                                        $(this).prop('checked', false);
                                                    });
                                                    $.post("AjaxProcess/GestionRole/AjouterRole.php", {perms: JSON.stringify(array), nomRole: $("#roleName").val()}, function (data, status) {
                                                        if (data != null || data != '') {
                                                            $(".roles").append('<option value="' + data + '">' + $("#roleName").val() + '</option>');
                                                            $("#mAddRole").hide();
                                                            displayNotification("Role ajouté avec succés", "success");
                                                        } else {
                                                            displayNotification(data, "danger");
                                                        }
                                                    });
                                                } else {
                                                    $("#roleName").addClass("errors");
                                                }
                                            }
                                            function ModifierRole() {
                                                var array = [];
                                                $("input:checkbox[name=Modifpermissions]:checked").each(function () {
                                                    array.push($(this).val());
                                                });
                                                $.post("AjaxProcess/GestionRole/ModifierRole.php", {idRole: $("#ModifRole").val(), perms: JSON.stringify(array)}, function (data, status) {
                                                    if (parseInt(data) === 1) {
                                                        $("#mModifierRole").hide();
                                                        displayNotification("Role modifié avec succés", "success");
                                                    } else {
                                                        displayNotification(data, "danger");
                                                    }
                                                });
                                            }

                                            $(document).ready(function () {
                                                $('input').each(function () {
                                                    var self = $(this),
                                                            label = self.next(),
                                                            label_text = label.text();
                                                    label.remove();
                                                    self.iCheck({
                                                        checkboxClass: 'icheckbox_line-blue',
                                                        insert: '<div class="icheck_line-icon"></div>' + label_text
                                                    });
                                                });
                                                $('#listeusers').DataTable({
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
                                                    "autoWidth": false
                                                });
                                            });
                                            function showConfig(id) {

                                            }

                                            $('[data-toggle=confirmation]').confirmation({
                                                rootSelector: '[data-toggle=confirmation]',
                                                container: 'body',
                                                onConfirm: function (event, element) {
                                                    console.log(element);
                                                    console.log(event);
                                                }
                                            });
                                            $(document).ajaxStart(function () {
                                                $.LoadingOverlay("show", {
                                                    image: "",
                                                    fontawesome: "fa fa-hourglass-start fa-spin"
                                                });
                                            });
                                            $(document).ajaxStop(function () {
                                                $.LoadingOverlay("hide");
                                            });
                                            function loadUser(id) {
                                                $.post("AjaxProcess/getUser.php", {user_id: id}, function (data, status) {
                                                    $("#Modifuser_name").val(data.user_name);
                                                    $("#Modifuser_email").val(data.user_email);
//                                                          $("#Modifuser_").val(data);
                                                });
                                                $("#modifModal").show();
                                            }
        </script>
    </body>
</html>
