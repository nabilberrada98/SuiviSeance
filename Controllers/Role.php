<?php
class Role
{
    protected $permissions;

    protected function __construct() {
        $this->permissions = array();
    }
    public static function getRolePerms($role_id) {
        $role = new Role();
        $sql = "SELECT t2.perm_desc FROM role_perm as t1
                JOIN permissions as t2 ON t1.perm_id = t2.perm_id
                WHERE t1.role_id = ?";
        $controller=new Controller();
        $sth = $controller->query($sql,[$role_id],"json",false);
        foreach($sth as $row) {
            $role->permissions[$row["perm_desc"]] = true;
        }
        return $role;
    }

    public function hasPerm($permission) {
        return isset($this->permissions[$permission]);
    }
}