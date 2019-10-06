<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GestionDesMatieresController extends Controller {

    public function getAllMatieres() {
        return $this->query("select u.user_name, m.* from matieres m ,users u where m.id_prof=u.user_id order by m.nom", null, "MatiereEntity", false);
    }
    
    
    
    public function getModifierInfos($id) {
        $res=[];
        $infos = $this->query("select nom , volume_heures , prix_par_heure , id_prof , metadata from matieres where id = ?",[$id],"MatiereEntity",true);
        $res['metadata']= json_decode($infos['metadata']);
        $res['nom']=$infos['nom'];
        $res['volume_heures']=$infos['volume_heures'];
        $res['prix_par_heure']=$infos['prix_par_heure'];
        $res['id_prof']=$infos['id_prof'];
        return $res;
    }
    public function getInfos($id) {
        $res=[];
        $filSem = $this->query("select f.nom_filiere , s.nomSemestre from semestres s , filieres f , matieres m where m.id_semestre = s.id and s.id_filiere=f.id and m.id= ? ",[$id],"MatiereEntity",true);
        $accmp=  $this->query("select (100*((m.volume_heures*60)- ((m.volume_heures*60)-sum(time_to_sec(timediff(se.date_fin, se.date_debut ))/60)) )) /(m.volume_heures * 60) as reste_a_faire from matieres m , seances se where m.id=se.id_matiere and m.id=? group by m.nom ",[$id],"MatiereEntity",true);
        $res['filiere']=$filSem['nom_filiere'];
        $res['semestre']=$filSem['nomSemestre'];
        $res['acomp']=$accmp['reste_a_faire'];
        return $res;
    }

    public function getAllFilieres() {
        return $this->query("select * from filieres order by nom_filiere",null,'FiliereEntity',false);
    }

    public function getAllProf() {
        return $this->query("select u.user_id,u.user_name from users u, user_role ur, roles r where u.user_id=ur.user_id and ur.role_id=r.role_id and r.role_name in ('Professeur','Administrateur')", null, "ProfesseurEntity", false);
    }

    public function supprimerMatiere($id) {
            $updated = $this->UpdateTable("delete from matieres where id = ?", [$id]);
            return $updated;
    }

    public function AddMatiere($nom, $Volume_heures, $prix_par_heure, $id_semestre, $id_prof,$metadata) {
            $id = $this->AddtoDb("insert into matieres values(null,?,?,?,?,?,?)", [$nom, $Volume_heures, $prix_par_heure,$metadata, $id_semestre, $id_prof]);
            return $id;
    }

    public function modifierMatiere($id,$nom, $Volume_heures, $prix_par_heure, $id_semestre, $id_prof,$metadata) {
            return $this->UpdateTable("update matieres set nom= ?, volume_heures = ? , prix_par_heure = ? , id_semestre=? , id_prof=? , metadata = ? where id = ?", [$nom,$Volume_heures, $prix_par_heure, $id_semestre, $id_prof,$metadata, $id]);
    }

}
