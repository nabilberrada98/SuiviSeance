<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CalendrierController
 *
 * @author Nabil
 */
class CalendrierController extends Controller {

    public function addRetard($id, $retard) {
        return $this->UpdateTable("update seances set etat = 'retard' , retard = ? where id = ?", [$retard, $id]);
    }

    public function EventInfo($id) {
        $event = $this->query("select m.id, u.user_name from seances s , matieres m ,users u where s.id_matiere = m.id and m.id_prof = u.user_id and s.id = ?", [$id], "json", true);
        $intervenans = $this->query("select e.civilite,e.email from etudiants e ,etud_matiere ed, matieres m where ed.id_etudiant=e.id AND ed.id_matiere=m.id and m.id=?", [$event['id']], "json", false);
        $event['intervenants'] = $intervenans;
        return json_encode($event);
    }

    public function getEvents($semestre, $type) {
        $events = $this->query("Select s.id,s.date_debut,s.date_fin,s.etat,s.motif,m.nom,m.id_semestre,s.retard,s.metadata from seances s , matieres m where s.id_matiere=m.id and m.id_semestre = ? and s.type = ?", [$semestre, $type], "json", false);
        $keys = array('id', 'start', 'end', 'etat', 'motif', 'title', 'idsemestre','retard');
        $resultat = array();
        foreach ($events as $value) {
            $metadata = json_decode(array_pop($value), true);
            array_push($resultat, array_merge((array_combine($keys, array_values($value))), $metadata));
        }
        $json = json_encode($resultat);
        return $json;
    }

    public function addSeance($start, $end, $type, $etat, $motif, $metadata, $id_matiere, $id_salle) {
        return $this->AddtoDb("Insert into seances values(null,?,?,?,?,?,?,?,?)", [$start, $end, $type, $etat, $motif, $metadata, $id_matiere, $id_salle]);
    }

    public function AnnulerSeance($id, $motif) {
        return $this->UpdateTable("Update seances set etat='annulé' , motif=? where id = ?", [$motif, $id]);
    }

    public function SupprimerSeance($id) {
        return $this->UpdateTable("delete from seances where id = ?", [$id]);
    }

    public function ModifierSeance($id, $start, $end, $matiereId) {
        return $this->UpdateTable("Update seances set date_debut = ? , date_fin = ? , id_matiere = ? where id = ?", [$start, $end, $matiereId, $id]);
    }

    public function getAllProffeseurs() {
        $profs = $this->query("Select u.user_id , u.user_name from users u , user_role ur , roles r where u.user_id=ur.user_id and ur.role_id = r.role_id and r.role_name='Professeur' order by u.user_name ", null, "ProfesseurEntity", false);
        return $profs;
    }

    public function getAllMatieres($groupe) {
        $matieres = $this->query("Select id,nom from matieres where id_semestre = ?  order by nom", [$groupe], "json", false);
        return $matieres;
    }

    public function getAllSalles() {
        $salles = $this->query("Select id from salles order by id", null, "SalleEntity", false);
        return $salles;
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
