<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GestionDesMatieresController extends Controller {
    public function getAllFilieres(){
        return $this->query("select * from filieres order by nom_filiere");
    }
    
    public function SupprimerMatiere($id){
        return $this->UpdateTable("delete from matieres where id = ?", [$id]);
    }
}