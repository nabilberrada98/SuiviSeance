<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author Nabil
 */
class Controller {

    function convertToHoursMins($time) {
        if ($time < 1) {
            return;
        }
        $hours = floor(floatval($time) / 60);
        $minutes = (floatval($time) % 60);
        return $hours . " h et " . $minutes . " min";
    }

    protected $db_instance;

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public static function CreateView($viewName) {
        require_once "Views/$viewName.php";
    }

    public function getDb() {
        $config = Config::getInstance(dirname(__DIR__) . '\Config\config.php');
        if (is_null($this->db_instance)) {
            $this->db_instance = new Database($config->get('db_name'), $config->get('db_user'), $config->get('db_pass'), $config->get('db_host'));
        }
        return $this->db_instance;
    }

    public function query($statement, $attribute = null, $class_name = null, $one = false) {
        if ($attribute) {
            return $this->getDb()->prepare($statement, $attribute, $class_name, $one);
        } else {
            return $this->getDb()->query($statement, $class_name, $one);
        }
    }

    public function AddtoDb($statement, $attributes) {
        return $this->getDb()->AddtoDb($statement, $attributes);
    }

    public function UpdateTable($statement, $attributes) {
        return $this->getDb()->UpdateTable($statement, $attributes);
    }

    public static function notFound() {
        header("HTTP/1.0 404 Not Found");
        die('page Introuvable');
    }

    public static function forbidden() {
        header('HTTP/1.0 403 Forbidden');
        die('Accé interdit');
    }

    public function sendMail($idSeance, $dateAnnulation, $heureAnnulation) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $toList=[];
            $adresseDistrub = $this->query("select m.nom ,f.email_groupe as email from seances se , matieres m , semestres s , filieres f where se.id_matiere=m.id and m.id_semestre=s.id and s.id_filiere=f.id and  se.id = ?",[$idSeance],"json",true);
            if (is_null($adresseDistrub)) {
                $toList = $this->query("select m.nom , e.email from etudiants e , etud_semestre es , semestres sm,matieres m , seances s where e.id = es.id_etudiant and es.id_semestre = sm.id and m.id_semestre=sm.id and s.id_matiere=m.id and s.id = ? ", [$idSeance], "json", false);
            }else{
                array_push($toList, $adresseDistrub);
            }
            $mail = new PHPMailer(true);
            $mail->CharSet = "utf-8";
            $mail->IsHTML(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'suivi2seance@gmail.com';                 // SMTP username
            $mail->Password = 'VinciSuiviSeances';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $name = 'SuiviSeances';
            $mail->setFrom('suivi2seance@gmail.com', $name);
            $mail->AddReplyTo('suivi2seance@gmail.com', $name);
            $mail->Subject = 'Annulation de la séance ' . $toList[0]['nom'];
            $mail->SMTPDebug = 2;
            $body = '<html>
      <body>
        <h3>Nous tenons à vous informer que la séance prévue pour le <strong>' . $dateAnnulation . '</strong> a <strong>' . $heureAnnulation . '</strong> a été annulé .</h3>
       <br>
       <table border="0" cellspacing="0" cellpadding="0">
       <tbody>
        <tr>
           <td><img src="https://vinci.ma/wp-content/themes/vinci/images/logo.png?x49426"/></td>
            <td width="272">            
            <p><strong>Application Suivi de Seances</strong></p>
            <p>+212 (0) 5 37 70 69 05</p>
            <p>Adresse: 10, Rue Al Yamama, Rabat,&nbsp;Maroc</p>
            </td>               
            </tr>                
            </tbody>                
            </table>
      </body>
     </html>';
            $mail->MsgHTML($body);
            foreach ($toList as $etudiant) :
                $mail->addAddress($etudiant['email']);
            endforeach;
            $sendmail = $mail->send();
            if (!$sendmail) {
                echo $mail->ErrorInfo;
            }
        }
        return $sendmail;
    }

}
