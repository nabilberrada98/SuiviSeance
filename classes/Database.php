<?php

class Database {

    private $db_name;
    private $db_user;
    private $db_pass;
    private $db_host;
    private $pdo;

    public function __construct($dbname, $db_user = "root", $db_pass = "", $db_host = "localhost") {
        $this->db_name = $dbname;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
    }

    public function getPDO() {
        $pdo = new PDO('mysql:host=' . $this->db_host . ';dbname=' . $this->db_name, $this->db_user, $this->db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo = $pdo;
        return $pdo;
    }

    public function query($statement, $class_name = null , $one = false) {
        $st = $this->getPDO()->query($statement);
        if ($class_name === null) {
            $st->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $st->setFetchMode(PDO::FETCH_CLASS, $class_name);
        }

        if ($one) {
            $datas = $st->fetch();
        } else {
            $datas = $st->fetchAll();
        }
        return $datas;
    }

    public function prepare($statement, $attributes, $class_name = null, $one = false) {
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
        return $datas;
    }

    public function AddtoDb($statement, $attributes) {
        $conn = $this->getPDO();
        $req = $conn->prepare($statement);
        $req->execute($attributes);
        $id = $conn->lastInsertId();
        return $id;
    }

    public function UpdateTable($statement, $attributes) {
        $conn = $this->getPDO();
        $req = $conn->prepare($statement);
        return $req->execute($attributes);
    }

}
