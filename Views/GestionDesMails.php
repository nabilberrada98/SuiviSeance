 
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
?>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="Views/dist/img/logo.png" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Messages</title>
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
        <?php
        if (isset($googleId) && !empty($googleId)) {
            ?>
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
                            Mailbox
                            <small>13 new messages</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                            <li class="active">Mailbox</li>
                        </ol>
                    </section>

                    <!-- Main content -->
                    <section class="content">
                        <div class="row">
                            <div class="col-md-3">
                                <a href="compose" class="btn btn-primary btn-block margin-bottom">Compose</a>
                                
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Folders</h3>

                                        <div class="box-tools">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="box-body no-padding">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li class="active"><a href="#"><i class="fa fa-inbox"></i> Inbox
                                                    <span class="label label-primary pull-right">12</span></a></li>
                                            <li><a href="#"><i class="fa fa-envelope-o"></i> Sent</a></li>
                                            <li><a href="#"><i class="fa fa-file-text-o"></i> Drafts</a></li>
                                            <li><a href="#"><i class="fa fa-filter"></i> Junk <span class="label label-warning pull-right">65</span></a>
                                            </li>
                                            <li><a href="#"><i class="fa fa-trash-o"></i> Trash</a></li>
                                        </ul>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /. box -->
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Labels</h3>

                                        <div class="box-tools">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="box-body no-padding">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li><a href="#"><i class="fa fa-circle-o text-red"></i> Important</a></li>
                                            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> Promotions</a></li>
                                            <li><a href="#"><i class="fa fa-circle-o text-light-blue"></i> Social</a></li>
                                        </ul>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-9">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Inbox</h3>

                                        <div class="box-tools pull-right">
                                            <div class="has-feedback">
                                                <input type="text" class="form-control input-sm" placeholder="Search Mail">
                                                <span class="glyphicon glyphicon-search form-control-feedback"></span>
                                            </div>
                                        </div>
                                        <!-- /.box-tools -->
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body no-padding">
                                        <div class="mailbox-controls">
                                            <!-- Check all button -->
                                            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                                            </button>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                                            </div>
                                            <!-- /.btn-group -->
                                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                                            <div class="pull-right">
                                                1-50/200
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                                                </div>
                                                <!-- /.btn-group -->
                                            </div>
                                            <!-- /.pull-right -->
                                        </div>
                                        <div class="table-responsive mailbox-messages">
                                            <table class="table table-hover table-striped">
                                                <tbody>
                                                    <tr>
                                                        <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                        <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                                                        <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                                        <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                                                        </td>
                                                        <td class="mailbox-attachment"></td>
                                                        <td class="mailbox-date">5 mins ago</td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                        <td class="mailbox-star"><a href="#"><i class="fa fa-star-o text-yellow"></i></a></td>
                                                        <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                                        <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                                                        </td>
                                                        <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                                                        <td class="mailbox-date">28 mins ago</td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                        <td class="mailbox-star"><a href="#"><i class="fa fa-star-o text-yellow"></i></a></td>
                                                        <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                                        <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                                                        </td>
                                                        <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                                                        <td class="mailbox-date">11 hours ago</td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                        <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                                                        <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                                        <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                                                        </td>
                                                        <td class="mailbox-attachment"></td>
                                                        <td class="mailbox-date">15 hours ago</td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                        <td class="mailbox-star"><a href="#"><i class="fa text-yellow fa-star-o"></i></a></td>
                                                        <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                                        <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                                                        </td>
                                                        <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                                                        <td class="mailbox-date">Yesterday</td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                        <td class="mailbox-star"><a href="#"><i class="fa fa-star-o text-yellow"></i></a></td>
                                                        <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                                        <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                                                        </td>
                                                        <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                                                        <td class="mailbox-date">2 days ago</td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                        <td class="mailbox-star"><a href="#"><i class="fa fa-star-o text-yellow"></i></a></td>
                                                        <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                                        <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                                                        </td>
                                                        <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                                                        <td class="mailbox-date">2 days ago</td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                        <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                                                        <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                                        <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                                                        </td>
                                                        <td class="mailbox-attachment"></td>
                                                        <td class="mailbox-date">2 days ago</td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                        <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                                                        <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                                        <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                                                        </td>
                                                        <td class="mailbox-attachment"></td>
                                                        <td class="mailbox-date">2 days ago</td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                        <td class="mailbox-star"><a href="#"><i class="fa fa-star-o text-yellow"></i></a></td>
                                                        <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                                        <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                                                        </td>
                                                        <td class="mailbox-attachment"></td>
                                                        <td class="mailbox-date">2 days ago</td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                        <td class="mailbox-star"><a href="#"><i class="fa fa-star-o text-yellow"></i></a></td>
                                                        <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                                        <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                                                        </td>
                                                        <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                                                        <td class="mailbox-date">4 days ago</td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                        <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                                                        <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                                        <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                                                        </td>
                                                        <td class="mailbox-attachment"></td>
                                                        <td class="mailbox-date">12 days ago</td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                        <td class="mailbox-star"><a href="#"><i class="fa fa-star-o text-yellow"></i></a></td>
                                                        <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                                        <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                                                        </td>
                                                        <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                                                        <td class="mailbox-date">12 days ago</td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                        <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                                                        <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                                        <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                                                        </td>
                                                        <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                                                        <td class="mailbox-date">14 days ago</td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                        <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                                                        <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                                        <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                                                        </td>
                                                        <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                                                        <td class="mailbox-date">15 days ago</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <!-- /.table -->
                                        </div>
                                        <!-- /.mail-box-messages -->
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer no-padding">
                                        <div class="mailbox-controls">
                                            <!-- Check all button -->
                                            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                                            </button>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                                            </div>
                                            <!-- /.btn-group -->
                                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                                            <div class="pull-right">
                                                1-50/200
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                                                </div>
                                                <!-- /.btn-group -->
                                            </div>
                                            <!-- /.pull-right -->
                                        </div>
                                    </div>
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
        <script src="Views/plugins/select2/select2.full.min.js"></script>
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
                        $("#semestreId").append("<option data-feed='AjaxProcess/GetEvents.php?semestreParam=" + obj.id + "' value='" + obj.id + "'>" + obj.id + "</option>");
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
                $('#seance').daterangepicker({timePicker: true,
                    orientation: "bottom",
                    timePickerIncrement: 15, format: 'MM/DD/YYYY h:mm A'});
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
                            $.post("AjaxProcess/FullInfo.php", {id: EventModif.id}, function (data, status) {
                                $("#infoProf").text(data.nom);
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
                    radioClass: 'iradio_square-red',
                    increaseArea: '20%' // optional
                });
            });
            function displayNotification(text, className) {
                $.notify(text, {
                    clickToHide: true,
                    autoHide: true,
                    autoHideDelay: 3000,
                    arrowSize: 50,
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
                $.post("AjaxProcess/addEvent.php", {date_debut: addStart, date_fin: addEnd, type: 'cour', etat: etat, motif: motif, metadata: metadata, id_matiere: id_matiere, id_salle: id_salle}, function (data, status) {
                    if (!isNaN(parseInt(data))) {
                        $('#calendar').fullCalendar('refetchEvents');
                        displayNotification('Seance Ajouté avec succés', 'success');
                        $('#addSeance').modal('hide');
                    } else {
                        displayNotification('Oups ! une érreur s\'est produite', 'danger');
                    }
                });
            }

            function AnnulerSeance() {
                var mot = $("#modifMotif").val();
                $.post("AjaxProcess/AnnulerEvent.php", {motif: mot, id: EventModif.id}, function (data, status) {
                    if (parseInt(data) >= 1) {
                        EventModif.etat = "annulé";
                        EventModif.motif = mot;
                        $('#calendar').fullCalendar('updateEvent', EventModif);
                        $('#CRUDmodal').modal('hide');
                        displayNotification('Seance annulé', 'success');
                    }
                });
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
