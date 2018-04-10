<?php
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
?>
<!DOCTYPE html>
<html>
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
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="Views/dist/css/AdminLTE.min.css">
        <link href="Views/dist/css/animate.css" rel="stylesheet" type="text/css"/>
        <link href="Views/dist/css/ftAwesomeAnims.css" rel="stylesheet" type="text/css"/>
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <meta name="google-signin-client_id" content="690957902726-bsjd7k4ph4sosktq7ri90f2vat9apg5m.apps.googleusercontent.com">
        <script src="Views/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="Views/plugins/iCheck/square/blue.css">
        <script src="Views/plugins/iCheck/icheck.min.js"></script>
        <script>
            /*
             function logIn(username, pass, saveSes) {
             $('#loginform').removeClass("has-error");
             $('#passform').removeClass("has-error");
             console.log(saveSes);
             $.post("AjaxProcess/ProcessLogin.php", {emailParam: username, passParam: pass, remember: saveSes}, function (data, status) {
             console.log(data + '\n');
             if (data == "login") {
             $('#loginform').addClass("has-error");
             } else if (data == "pass") {
             $('#passform').addClass("has-error");
             } else if (data == "ok") {
             window.location.href = "CalendrierDesCours";
             }
             });
             }*/
            //gapi.auth2.getAuthInstance().disconnect();
            //onload get
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    increaseArea: '20%' 
                });
            });
            function Google_signIn(googleUser) {
                var profile = googleUser.getBasicProfile();
                update_user_data(profile);
            }
            function update_user_data(response) {
                $('#googleauth').removeClass("shake");
                $.post("AjaxProcess/check_user.php", {googleId: response.Eea, email : response.U3 ,username : response.ig ,imgPath : response.Paa, saveSes: $("#saveSession").is(':checked')}, function (data, status) {
                    if (data == "ok") {
                        window.location.href = "CalendrierDesCours";
                    }else{
                        console.log(data);
                        $('#googleauth').addClass("shake");
                    }
                });
            }
        </script>
    </head>
    <body class="hold-transition login-page">
        <div class="login-box animated fadeInDown">
            <div class="login-logo">
                <a href="login.php" ><b>Suivi</b>Seances</a>
            </div>
            <div class="login-box-body">
                <p class="login-box-msg">Connectez-vous afin d'accéder a l'application</p>
                <!--                    <div class="form-group has-feedback" id="loginform">
                                        <input type="text" name="username" class="form-control" placeholder="Username">
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                    <div class="form-group has-feedback" id="passform">
                                        <input type="password" name="pass" class="form-control" placeholder="Password">
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                    </div>
                -->
                <div>
                    <center><i class="fa fa-hand-o-down faa-vertical fa-2x animated"></i><div class="g-signin2 animated" id="googleauth" data-prompt="consent" data-longtitle="true" data-onsuccess="Google_signIn" data-theme="dark" data-width="200"></div></center>
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
