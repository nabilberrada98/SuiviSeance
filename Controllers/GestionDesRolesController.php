<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GestionDesRolesController extends Controller {

    public function addUser($user_email, $userphone, $roleid) {
        try {
            $id = $this->AddtoDb("insert into users (user_email,user_phone) values (?,?)", [$user_email, $userphone]);
            $this->AddtoDb("insert into user_role values(?,?)", [$id, $roleid]);
            return 'success';
        } catch (Exception $e) {
            return 'Erreur de traitement : exception reçue : ' . $e->getMessage() . "\n";
        }
    }

    public function getUserPerms($idRole) {
        return $this->query("select p.perm_id from permissions p , role_perm rp where p.perm_id=rp.perm_id and rp.role_id = ?", [$idRole], "json");
    }

    public function supprimerRole($idRole) {
        try {
            $this->UpdateTable("delete from role_perm where role_id = ?", [$idRole]);
            $updated = $this->UpdateTable("delete from roles where role_id = ?", [$idRole]);
            return $updated;
        } catch (Exception $e) {
            echo 'Erreur de traitement : exception reçue : ', $e->getMessage(), "\n";
        }
    }

    public function modifierRole($idRole, $perms) {
        try {
            $updated = $this->UpdateTable("delete from role_perm where role_id = ?", [$idRole]);
            foreach ($perms as $permission) {
                $this->AddtoDb("insert into role_perm values(?,?) ", [$idRole, $permission]);
            }
            return $updated;
        } catch (Exception $e) {
            echo 'Erreur de traitement : exception reçue : ', $e->getMessage(), "\n";
        }
    }

    public function getAllUsers() {
        return $this->query("SELECT u.*,r.* FROM users u , user_role ur , roles r where u.user_id = ur.user_id and ur.role_id = r.role_id", null, "UserEntity", false);
    }

    public function getAllPermissions() {
        return $this->query("select * from permissions order by perm_desc", null, "PermissionsEntity");
    }

    public function getAllRoles() {
        return $this->query("SELECT * FROM roles r order by role_name", null, "RoleEntity", false);
    }

    public function AddRole($nomRole, $perms) {
        try {
            $idRole = $this->AddtoDb("insert into roles values(null,?)", [$nomRole]);
            foreach ($perms as $permission) {
                $this->AddtoDb("insert into role_perm values(?,?) ", [$idRole, $permission]);
            }
            return $idRole;
        } catch (Exception $e) {
            echo 'Erreur de traitement : exception reçue : ', $e->getMessage(), "\n";
        }
    }

}
