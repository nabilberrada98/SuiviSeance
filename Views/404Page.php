 <!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->

<?php
?>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="Views/dist/img/logo.png" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Messages</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="Views/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="Views/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="Views/dist/css/skins/skin-blue.min.css">
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
        <div class="wrapper">
            <!-- Main Header -->
            <?php require_once 'includes/header.php'; ?>
            <!-- Left side column. contains the logo and sidebar -->
            <?php require_once 'includes/Menu.php'; ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="min-height: 1126px;">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Erreur 404
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content animated zoomInDown">
                    <div class="error-page">
                        <h2 class="headline text-yellow">404</h2>

                        <div class="error-content">
                            <h3><i class="fa fa-warning text-yellow"></i> Oops! Page introuvable.</h3>
                            <p>
                                La page que vous avez demandé est introuvable.
                                toutefois vous pouvez retourner a la page principale <a href="./">retour au dashboard</a> 
                            </p>
                        </div>
                    </div>
                </section>
            </div>
            <?php include 'includes/footer.php'; ?>
        </div>

        <link href="Views/dist/css/animate.css" rel="stylesheet" type="text/css"/>

        <!-- Optionally, you can add Slimscroll and FastClick plugins.
             Both of these plugins are recommended to enhance the
             user experience. Slimscroll is required when using the
             fixed layout. -->
    </body>
</html>
