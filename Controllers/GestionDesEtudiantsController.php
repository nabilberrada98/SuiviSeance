<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GestionDesEtudiantsController extends Controller {

    public function getAllFilieres() {
        return $this->query("select * from filieres order by nom_filiere",null,'FiliereEntity',false);
    }

    public function getAllEtudiants() {
        return $this->query("select f.id as filId,f.nom_filiere , e.* from etudiants e , filieres f where e.id_filiere = f.id order by f.nom_filiere",null,"UserEntity",false);
    }
    
    public function supprimerEtudiant($id) {
        try {
            $updated = $this->UpdateTable("delete from etudiants where id = ?", [$id]);
            return $updated;
        } catch (Exception $e) {
            echo 'Erreur de traitement : exception reçue : ', $e->getMessage(), "\n";
        }
    }

    public function ajouterEtudiant($civilite,$email,$fil) {
        try {
            $id = $this->AddtoDb("insert into etudiants values(null,?,?,?)", [$civilite, $email, $fil]);
            return $id;
        } catch (Exception $e) {
            echo 'Erreur de traitement : exception reçue : ', $e->getMessage(), "\n";
        }
    }

    public function modifierEtudiant($id, $civilite,$email,$fil) {
        try {
            return $this->UpdateTable("update etudiants set civilite = ? , email= ? , id_filiere=? where id = ?", [$civilite, $email, $fil, $id]);
        } catch (Exception $e) {
             echo 'Erreur de traitement : exception reçue : ', $e->getMessage(), "\n";
        }
    }

}
