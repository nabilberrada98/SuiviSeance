<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LoginController extends Controller {
    public function googleAuth($googleId, $email, $imgPath, $username, $saveSes) {
        $user = $this->query("SELECT user_id , google_id,etat FROM users WHERE user_email = ?", [$email], "UserEntity", true);
        if ($user) {
            if ($user->etat == 1) {
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
                return 'Votre compte est désactiver pour l\'instant , veuillez consulter votre administrateur';
            }
        } else {
            return 'Votre compte n\'est pas autorisé accéder a cette application';
        }
    }

    public static function Deconnection() {
        session_start();
        unset($_COOKIE['googleId']);
        setcookie('googleId', null, -1, '/');
        session_unset();
        header("Location: ../login");
    }

}
