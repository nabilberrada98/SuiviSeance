<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GestionDesSemestresController extends Controller {
    
    public function getAllSemestres(){
        return $this->query("select f.nom_filiere,s.* from semestres s , filieres f where s.id_filiere = f.id",null, "SemestreEntity",false);
    }
    
    function supprimerSemestre($id) {
        return $this->UpdateTable("delete from semestres where id = ?", [$id]);
    }

    
    public function getAllFilieres() {
        return $this->query("select nom_filiere , id from filieres order by nom_filiere",null,"FiliereEntity",false);
    }

    public function supprimerFiliere($id) {
        try {
           
            $updated = $this->UpdateTable("delete from filieres where id = ?", [$id]);
            return $updated;
        } catch (Exception $e) {
            echo 'Erreur de traitement : exception reçue : ', $e->getMessage(), "\n";
        }
    }
    
    public function ajouterSemestre($idFiliere,$nomSemestre,$debut,$fin) {
        try {
            $this->AddtoDb("insert into semestres values (null,?,?,?,?)", [$nomSemestre,$debut,$fin,$idFiliere]);
            return 1;
        } catch (Exception $e) {
            echo 'Erreur de traitement : exception reçue : ', $e->getMessage(), "\n";
        }
    }
    
    public function modifierSemestre($id, $nom,$deb,$fin) {
        try {
            return $this->UpdateTable("update semestres set nomSemestre = ? , date_debut = ?,date_fin = ? where id = ? ", [$nom,$deb,$fin,$id]);
        } catch (Exception $e) {
            echo 'Erreur de traitement : exception reçue : ', $e->getMessage(), "\n";
        }
    }
    
}
