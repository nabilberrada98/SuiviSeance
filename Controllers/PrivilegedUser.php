<?php
class PrivilegedUser
{
    private $roles;
    public static function getByGoogleId($googleId) {
        $sql = "SELECT * FROM users WHERE google_id = ?";
        $controller =new Controller();
        $privUser = $controller->query($sql,[$googleId],"PrivilegedUser",true);
        $controller=null;
        if (!empty($privUser)) {
            $privUser->initRoles();
            return $privUser;
        } else {
            return false;
        }
    }
    protected function initRoles() {
        $this->roles = array();
        $controller =new Controller();
        $sql = "SELECT t1.role_id, t2.role_name FROM user_role as t1
                JOIN roles as t2 ON t1.role_id = t2.role_id
                WHERE t1.user_id = ?";
        $sth = $controller->query($sql,[$this->user_id],"json",false);
        $controller=null;
        foreach ($sth as $row) {
            $this->roles[utf8_encode($row["role_name"])] = Role::getRolePerms($row["role_id"]);
        }
    }
    public function hasPrivilege($perm) {
        foreach ($this->roles as $role) {
            if ($role->hasPerm($perm)) {
                return true;
            }
        }
        return false;
    }
}