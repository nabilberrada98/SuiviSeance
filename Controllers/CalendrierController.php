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
        $event = $this->query("select m.id, u.user_name , m.id_semestre from seances s , matieres m ,users u where s.id_matiere = m.id and m.id_prof = u.user_id and s.id = ?", [$id], "json", true);
        $intervenans = $this->query("select concat(u.user_name ,' (Professeur)') as civilite, u.user_email as email from users u , seances s , matieres m where s.id_matiere=m.id and m.id_prof=u.user_id and s.id = ? UNION select e.civilite,e.email from etudiants e ,filieres f,semestres s where  f.id=e.id_filiere and s.id_filiere = f.id and s.id = ?", [$id,$event['id_semestre']], "json", false);
        $event['intervenants'] = $intervenans;
        return json_encode($event);
    }


    public function addSeance($start, $end,  $etat, $motif, $id_matiere, $id_salle,$retard) {
        return $this->AddtoDb("Insert into seances values(null,?,?,?,?,?,?,?)", [$start, $end, $etat, $motif, $retard, $id_matiere, $id_salle]);
    }

    public function SupprimerSeance($id) {
        return $this->UpdateTable("delete from seances where id = ?", [$id]);
    }

    public function ModifierSeance($id, $start, $end, $matiereId) {
        return $this->UpdateTable("Update seances set date_debut = ? , date_fin = ? , id_matiere = ? where id = ?", [$start, $end, $matiereId, $id]);
    }

    public function getAllProffeseurs() {
        $profs = $this->query("Select u.user_id , u.user_name from users u , user_role ur , roles r where u.user_id=ur.user_id and ur.role_id = r.role_id and r.role_name in ('Professeur','Administrateur') order by u.user_name ", null, "ProfesseurEntity", false);
        return $profs;
    }


}
