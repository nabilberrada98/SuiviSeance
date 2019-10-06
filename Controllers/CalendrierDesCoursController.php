<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CalendrierDesCoursController extends CalendrierController{
       
    public function ProfisBusy($datedebut ,$datefin,$id_mat){
       return $this->query("select m.nom from seances s ,matieres m,matieres mparam where s.id_matiere = m.id and m.id_prof= mparam.id_prof and m.id<>mparam.id and ((s.date_debut <= ?) and (s.date_fin>=?)) and mparam.id=?",[$datefin,$datedebut,$id_mat],"MatiereEntity",true);
    }

    public function getRestriction($fil) {
        return $this->query("select date_debut , date_expiration from restrictions where id_filiere = ?",[$fil],"json",true);
    }
    
    public function getAllMatieres($groupe) {
        $matieres = $this->query("Select id , nom from matieres where id_semestre = ?  order by nom", [$groupe], "json", false);
        return $matieres;
    }
    
    public function getDateDebut($id) {
        return $this->query("select date_debut from semestres where id = ?",[$id],"SemestreEntity",true)['date_debut'];
    }
    public function getDateFin($id) {
        return $this->query("select date_fin from semestres where id = ?",[$id],"SemestreEntity",true)['date_fin'];
    }
    
    public function AnnulerSeance($id, $motif) {
        return $this->UpdateTable("Update seances set etat='annulé' , motif=? where id = ?", [$motif, $id]);
    }


     public function getEvents($semestre) {
        $events = $this->query("Select s.id,s.date_debut,s.date_fin,s.etat,s.motif,m.nom,m.id_semestre,s.retard,m.metadata from seances s , matieres m where s.id_matiere=m.id and m.id_semestre = ?", [$semestre], "json", false);
        $keys = array('id', 'start', 'end', 'etat', 'motif', 'title', 'idsemestre','retard');
        $resultat = array();
        foreach ($events as $value) {
            $metadata = json_decode(array_pop($value), true);
            array_push($resultat, array_merge((array_combine($keys, array_values($value))), $metadata));
        }
        $json = json_encode($resultat);
        return $json;
    }
    
    public function getAllFilieres() {
        $filieres = $this->query("Select * from filieres order by id", null, "FiliereEntity", false);
        return $filieres;
    }

    public function getAllSemestres($filiere) {
        $filieres = $this->query("Select id,nomSemestre from semestres where id_filiere = ? order by id", [$filiere], "json", false);
        return $filieres;
    }

}