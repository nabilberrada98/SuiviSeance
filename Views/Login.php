<?php
require_once __DIR__ . '/api/vendor/autoload.php';
require_once dirname(__DIR__) . '/classes/Config.php';

$config = Config::getInstance(dirname(__DIR__) . '\Config\config.php');
$client = new Google_Client();
$client->setClientId($config->get('client_id'));
$client->setClientSecret($config->get('client_secret'));
$client->setRedirectUri($config->get('redirect_uri'));
$client->setScopes('email');
$plus = new Google_Service_Plus($client);
if (isset($_COOKIE["googleId"])) {
    $privUser = PrivilegedUser::getByGoogleId($_COOKIE["googleId"]);
    if (!is_null($privUser)) {
        session_start();
        $_SESSION['googleId'] = $privUser->google_id;
        $_SESSION['user_name'] = $privUser->user_name;
        $_SESSION['user_email'] = $privUser->user_email;
        $_SESSION['user_img_path'] = $privUser->user_img_path;
        header("Location: CalendrierDesCours");
    }
}
$authUrl = $client->createAuthUrl();
?>
<!DOCTYPE html>
<html style="height: auto;">
    <head>
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="Views/dist/img/logo.png" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Log in | SuiviSeances </title>
        <script src="Views/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="Views/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="Views/dist/css/AdminLTE.min.css">
        <link href="Views/dist/css/animate.css" rel="stylesheet" type="text/css"/>
        <link href="Views/dist/css/ftAwesomeAnims.css" rel="stylesheet" type="text/css"/>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="Views/plugins/iCheck/square/blue.css">
        <script src="Views/plugins/iCheck/icheck.min.js"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    increaseArea: '20%'
                });
            });
        </script>
    </head>
    <body class="hold-transition login-page">
        <div class="login-box animated fadeInDown">
            <div class="login-logo">
                <a href="login" ><b>Suivi</b>Seances</a>
            </div>
            <div class="login-box-body">
                <p class="login-box-msg">Connectez-vous afin d'accéder a l'application</p>
                <div>
                    <Center><i class="fa fa-hand-o-down faa-vertical fa-2x animated"></i></Center><br>
                    <a class='login btn btn-large btn-google animated <?=(isset($_GET['error']) ? 'shake' : '')?>' href='<?= $authUrl ?>' style="width: 70%;margin-left: 15%;margin-right: 15%"><i class="fa fa-google-plus"></i> &nbsp; Se connecter</a>
                    <br>
                    <span id="errLog" style="color: red;"><?=(isset($_GET['error']) ? $_GET['error'] : '')?></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" id="saveSession"> Enregister la session
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
