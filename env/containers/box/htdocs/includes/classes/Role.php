<?php

class Role {
    public int $id;
    public string $name;
    
    public function __construct(int $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public function ListPermissions() {
        RolesPermissionsRepo::ListPermissionsForRoleId($this->id);
        $query = "SELECT p.*
            FROM " . RoleRepo::$table . " as r
            JOIN " . RolesPermissionsRepo::$table . " as rp
                ON rp.role_id = r.id
            JOIN " . PermissionRepo::$table . " as r
                ON rp.permission_id = p.id
            WHERE r.id = '{$this->id}'
        ";
        $res = pg_exec(PSQLFactory::getInstance()->connect(), $query);
        return $res !== false;
    }

}