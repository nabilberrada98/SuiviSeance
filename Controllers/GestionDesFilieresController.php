<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GestionDesFilieresController extends Controller {
    
    function getAllbyRole($role) {
        return $this->query("select u.user_id,u.user_name from users u,user_role ur , roles r where u.user_id = ur.user_id and ur.role_id = r.role_id and r.role_name in(?,'Administrateur')   ",[$role],"UserEntity",false);
    }

    public function getAllFilieres() {
        $listeFilieres = $this->query("select dr.user_name as directeur_pedagogique ,rs.user_name as responsable_scolarite , f.nom_filiere , f.id,f.email_groupe from filieres f, users dr , users rs where f.directeur_pedagogique = dr.user_id and f.responsable_scolarite= rs.user_id order by nom_filiere",null,'json',false);
        for ($index = 0; $index < count($listeFilieres); $index++) {
            $listeSemestre = $this->query("select nomSemestre from semestres where id_filiere = ?",[$listeFilieres[$index]['id']],'json',false);
            $semestres=[];
            foreach ($listeSemestre as $arr):
                array_push($semestres, $arr['nomSemestre']);
            endforeach;
            $listeFilieres[$index]['semestres']=join(',', $semestres);
        }
        return $listeFilieres;
    }

    public function getAllUsers() {
        return $this->query("select * from users order by suer_id", null, "UserEntity", false);
    }

    
    public function supprimerFiliere($id) {
        try {
           
            $updated = $this->UpdateTable("delete from filieres where id = ?", [$id]);
            return $updated;
        } catch (Exception $e) {
            echo 'Erreur de traitement : exception reçue : ', $e->getMessage(), "\n";
        }
    }
    
    public function AddFiliere($nom_filiere,$directeur_pedagogique,$responsable_scolarite,$email) {
        try {
            $id = $this->AddtoDb("insert into filieres values (null,?,?,?,?)", [$nom_filiere,$directeur_pedagogique,$responsable_scolarite,$email]);
//           for ($index = 0; $index < $nbrsemestre ; $index++) {
//                $nomsemestre = 'S'.($index+1);
//                $this->AddtoDb("insert into semestres values (null,?,?)", [$nomsemestre,$id]);
//            }
            return $id;
        } catch (Exception $e) {
            echo 'Erreur de traitement : exception reçue : ', $e->getMessage(), "\n";
        }
    }
    
    public function modifierFiliere($id, $nom_filere,$directeur_pedagogique,$responsable_scolarite,$email) {
        try {
            return $this->UpdateTable("update filieres set nom_filiere = ? , directeur_pedagogique = ? ,responsable_scolarite=? ,email_groupe = ? where id = ? ", [$nom_filere,$directeur_pedagogique,$responsable_scolarite,$email,$id]);
        } catch (Exception $e) {
            echo 'Erreur de traitement : exception reçue : ', $e->getMessage(), "\n";
        }
    }
}
