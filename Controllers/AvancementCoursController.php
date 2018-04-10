<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AvancementCoursController extends Controller {

    public function getAvancementCours() {
        return $this->query("SELECT u.user_name as prof_name,u.user_email as prof_email,u.user_phone as prof_phone, m.nom ,m.volume_heures,count(s.id) as total_seance ,count(case s.etat when 'retard' then 1 else null end) as nbr_retard,sum(case s.etat when 'retard' then s.retard else 0 end) as total_retard,ROUND((m.volume_heures-sum(time_to_sec(timediff(s.date_fin, s.date_debut )) / 3600))/1.5,0) as seances_restantes, sum(time_to_sec(timediff(s.date_fin, s.date_debut )) / 60) as realise, (m.volume_heures*60)-sum(time_to_sec(timediff(s.date_fin, s.date_debut ))/60) as reste_a_faire , uResp.user_name as responsable_name ,uResp.user_phone as responsable_phone ,uResp.user_email as responsable_email , uDir.user_name as directeur_name ,uDir.user_phone as directeur_phone ,uDir.user_email as directeur_email from users u , users uResp ,users uDir , semestres se , filieres f, user_role ur, roles r , matieres m , seances s  where u.user_id=ur.user_id and ur.role_id=r.role_id and r.role_name='professeur' AND m.id_prof=u.user_id AND s.id_matiere=m.id and s.etat<>'annulÃ©' and m.id_semestre=se.id and se.id_filiere=f.id and f.directeur_pedagogique=uDir.user_id and f.responsable_scolarite=uResp.user_id GROUP by m.nom,m.volume_heures", null, "MatiereEntity", false);
    }

    function convertToHoursMins($time) {
        if ($time < 1) {
            return;
        }
        $hours = floor( floatval($time) / 60);
        $minutes = (floatval($time) % 60);
        return $hours." h et ".$minutes." min";
    }

}
