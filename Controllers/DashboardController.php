<?php

class DashboardController extends Controller {

    const keys = array('name', 'y', 'drilldown');

    function getChartSemestresData() {
        $semestres = array();
        $filieres = $this->getAllFilieres();
        foreach ($filieres as $fil):
            array_push($semestres, $this->getSemestresFiliere($fil->id));
        endforeach;
        return join(',', $semestres);
    }

    function getChartMatieresData() {
        $matieres = array();
        $semestresL = $this->getAllSemestres();
        foreach ($semestresL as $sem):
            array_push($matieres, $this->getMatieresSemestre($sem['id']));
        endforeach;
        return join(',', $matieres);
    }

    function getFilieres() {
        $filieres = $this->getFiliereAvancement();
        $objSem = [];
        foreach ($filieres as $fil):
            array_push($objSem, array_combine(self::keys, $fil));
        endforeach;
        $res = array();
        $res['name'] = 'filières';
        $res['colorByPoint'] = true;
        $res['data'] = $objSem;
        return json_encode($res, JSON_NUMERIC_CHECK);
    }

    function getSemestresFiliere($idFil) {
        $semestres = $this->getSemestreAvancement($idFil);
        $objSem = [];
        foreach ($semestres as $sem):
            array_push($objSem, array_combine(self::keys, $sem));
        endforeach;
        $res = array();
        $res['id'] = $idFil;
        $res['data'] = $objSem;
        return json_encode($res, JSON_NUMERIC_CHECK);
    }

    function getMatieresSemestre($idSem) {
        $keys = array('name', 'y');
        $matieres = $this->getMatieresAvancement($idSem);
        $objSem = [];
        foreach ($matieres as $mat):
            array_push($objSem, array_combine($keys, $mat));
        endforeach;
        $res = array();
        $res['id'] = $idSem . 'S';
        $res['data'] = $objSem;
        return json_encode($res, JSON_NUMERIC_CHECK);
    }

    public function supprimerRestriction($id) {
        return $this->UpdateTable("delete from restrictions where id = ?", [$id]);
    }

    public function getAllRestrictions() {
        return $this->query("select r.*,f.nom_filiere from restrictions r ,filieres f where r.id_filiere=f.id order by f.nom_filiere", null, "FiliereEntity", false);
    }

    public function appliquerRestriction($fil, $dateDebut, $dateExp) {
        $this->UpdateTable("delete from restrictions where id_filiere = ?", [$fil]);
        return $this->AddtoDb("insert into restrictions values(null,?,?,?)", [$dateDebut, $dateExp, $fil]);
    }

    public function AssocierProfMatiere($mat, $prof) {
        return $this->UpdateTable("update matieres set id_prof = ? where id= ?", [$prof, $mat]);
    }

    public function getProfMatieres() {
        return $this->query("select u.user_name , m.nom,f.nom_filiere , s.nomSemestre from filieres f , semestres s , matieres m , users u where s.id_filiere = f.id and s.id = m.id_semestre and u.user_id=m.id_prof order by u.user_name", null, "ProfesseurEntity", false);
    }

    public function getAllProf() {
        return $this->query("select u.user_id,u.user_name from users u, user_role ur, roles r where u.user_id=ur.user_id and ur.role_id=r.role_id and r.role_name in ('Professeur','Administrateur')", null, "ProfesseurEntity", false);
    }

    public function ajouterPaiementHistorique($somme, $duree, $id_mat) {
        return $this->AddtoDb("insert into historique_paiement (id,somme_paye,duree_minutes,id_matiere) values(null,?,?,?)", [$somme, $duree, $id_mat]);
    }

    public function supprimerHistorique($id) {
        return $this->UpdateTable("delete from historique_paiement where id = ?", [$id]);
    }

    public function getHistorique() {
        return $this->query("select h.* , m.nom from historique_paiement h , matieres m where m.id = h.id_matiere order by h.date_paiement desc", null, "MatiereEntity", false);
    }

    public function getFiliereAvancement() {
        return $this->query("select f.nom_filiere ,TRUNCATE((100 * ((sum(m.volume_heures)*60) - (sum(m.volume_heures*60) - sum(se.avancemenMat)) )) / (sum(m.volume_heures* 60) ),2) as avancement ,f.id from matieres m , (Select sum(time_to_sec(timediff(date_fin, date_debut ))/60) as avancemenMat ,id_matiere from seances where etat<>'annulÃ©' group by id_matiere) se ,filieres f,semestres s where se.id_matiere = m.id  and m.id_semestre=s.id and s.id_filiere=f.id group by f.nom_filiere", null, "json", false);
    }

    public function getMatieresAvancement($idSemestre) {
        return $this->query("select m.nom,TRUNCATE((100 * ((m.volume_heures*60) - ( (m.volume_heures*60) - sum(time_to_sec(timediff(se.date_fin, se.date_debut ))/60)))) / (m.volume_heures* 60),2) as avancement from matieres m , semestres s, seances se where se.id_matiere=m.id and se.etat<>'annulÃ©' and m.id_semestre=s.id and s.id = ? group by m.nom", [$idSemestre], "json", false);
    }

    public function getSemestreAvancement($idfiliere) {
        return $this->query("select s.nomSemestre,TRUNCATE((100 * ((m.volume_heures*60) - ((m.volume_heures*60) - sum(time_to_sec(timediff(se.date_fin, se.date_debut ))/60)))) / (m.volume_heures* 60),2) as avancement, concat(s.id , 'S') as id from matieres m , semestres s,filieres f, seances se where se.id_matiere=m.id and se.etat<>'annulÃ©' and m.id_semestre=s.id and s.id_filiere=f.id  and f.id = ? group by s.nomSemestre", [$idfiliere], "json", false);
    }

    public function getAllSemestres() {
        return $this->query("select id from semestres order by nomSemestre", null, "json", false);
    }

    public function getAllFilieres() {
        return $this->query("select nom_filiere , id from filieres order by nom_filiere", null, "FiliereEntity", false);
    }

    public function getMatiereInfos($mat) {
        $paye = $this->query("SELECT sum(duree_minutes) as paye from historique_paiement where id_matiere = ?", [$mat], "MatiereEntity", true);
        $realise = $this->query("SELECT m.prix_par_heure, sum(time_to_sec(timediff(s.date_fin, s.date_debut )) / 60) as realise from matieres m , seances s  where s.id_matiere=m.id and s.etat<>'annulÃ©' and m.id = ? GROUP by m.prix_par_heure", [$mat], "MatiereEntity", true);
        $res = array();
        $res['prix_par_heure'] = $realise['prix_par_heure'];
        $res['paye'] = ($realise['realise'] - $paye['paye']);
        return $res;
    }

}
