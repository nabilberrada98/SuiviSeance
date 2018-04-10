<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GestionDesProfesseursController extends Controller {
    public function getAllProfs(){
        return $this->query("select * from users u , user_role ur , roles r where u.user_id=ur.user_id and ur.role_id = r.role_id and r.role_name='professeur'",null,'ProfesseurEntity',false);
    }
}
