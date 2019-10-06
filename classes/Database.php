<?php

class Database {

    private $db_name;
    private $db_user;
    private $db_pass;
    private $db_host;

    public function __construct($dbname, $db_user = "root", $db_pass = "", $db_host = "localhost") {
        $this->db_name = $dbname;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
    }

    public function getPDO() {
        try{
        $pdo = new PDO('mysql:host=' . $this->db_host . ';dbname=' . $this->db_name, $this->db_user, $this->db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(Exception $e){
             echo 'la base de donnée est indisponible pour le moment '.$e;
             exit;
        }
        return $pdo;
    }

    public function query($statement, $class_name = null , $one = false) {
        try{
        $st = $this->getPDO()->query($statement);
        if ($class_name === null) {
            $st->setFetchMode(PDO::FETCH_OBJ);
        }if ($class_name === "json") {
            $st->setFetchMode(PDO::FETCH_ASSOC);
        } else {
            $st->setFetchMode(PDO::FETCH_CLASS, $class_name);
        }

        if ($one) {
            $datas = $st->fetch();
        } else {
            $datas = $st->fetchAll();
        }
        }catch(Exception $e){
             echo "Opération échoué !";
             exit;
        }
        return $datas;
    }

    public function prepare($statement, $attributes, $class_name = null, $one = false) {
        try{
        $req = $this->getPDO()->prepare($statement);
        $req->execute($attributes);
        if ($class_name === null) {
            $req->setFetchMode(PDO::FETCH_OBJ);
        }if ($class_name === "json") {
            $req->setFetchMode(PDO::FETCH_ASSOC);
        } else {
            $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
        }
        if ($one) {
            $datas = $req->fetch();
        } else {
            $datas = $req->fetchAll();
        }
        }catch(Exception $e){
             echo "Opération échoué !";
             exit;
        }
        return $datas;
    }

    public function AddtoDb($statement, $attributes) {
        try{
        $conn = $this->getPDO();
        $req = $conn->prepare($statement);
        $req->execute($attributes);
        $id = $conn->lastInsertId();
        }catch(Exception $e){
             echo "Opération échoué !";
             exit;
        }
        return $id;
    }

    public function UpdateTable($statement, $attributes) {
        try{
        $conn = $this->getPDO();
        $req = $conn->prepare($statement);
        $state=$req->execute($attributes);
        }catch(Exception $e){
             echo "Opération échoué !";
             exit;
        }
        return $state;
    }

}
