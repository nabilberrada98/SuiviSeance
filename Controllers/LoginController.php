<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LoginController extends Controller {

//    public function login($username, $pass, $saveSes) {
//        $user = $this->query("Select * from users where login = ?", [$username], "UserEntity", true);
//        if ($user) {
//            if ($user->password === sha1($pass)) {
//                session_start();
//                $_SESSION['auth'] = $user->login;
//                $_SESSION['type'] = $user->role;
//                if ($saveSes == true) {
//                    setcookie("userType", $user->role, time() + (86400 * 30), "/");
//                }
//                // header("Location: http://$host$uri/$extra/CalendrierDesCours.php");
//                return 'ok';
//            } else {
//                echo 'pass';
//            }
//        } else {
//            echo 'login';
//        }
//    }

    function check_internet_connection($sCheckHost = 'www.google.com') {
        return (bool) @fsockopen($sCheckHost, 80, $iErrno, $sErrStr, 5);
    }

    public function googleAuth($googleId, $email, $imgPath, $username, $saveSes) {
        $user = $this->query("SELECT user_id , google_id FROM users WHERE user_email = ?", [$email], "UserEntity", true);
        if ($user) {
            session_start();
            if (is_null($user->google_id) || $user->google_id == '') {
                $this->UpdateTable("update users set google_id = ? , user_name = ? , user_img_path = ? where user_id = ?", [$googleId, $username, $imgPath, $user->user_id]);
            }
            $_SESSION['googleId'] = $googleId;
            $_SESSION['user_name'] = $username;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_img_path'] = $imgPath;
            if ($saveSes == 'true') {
                setcookie("googleId", $googleId, time() + (86400 * 90), "/");
            } else {
                unset($_COOKIE['googleId']);
                setcookie('googleId', null, -1, '/');
            }
            return 'ok';
        } else {
            return 'error';
        }
    }

    public static function Deconnection() {
        session_start();
        $_SESSION = array();
        session_destroy();
        unset($_COOKIE['googleId']);
        setcookie('googleId', null, -1, '/');
        header("Location: ../login");
    }

}
