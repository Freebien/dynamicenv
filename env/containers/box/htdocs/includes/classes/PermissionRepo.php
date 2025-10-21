<?php

require_once __DIR__ . "/Repo.php";
require_once __DIR__ . "/Role.php";
require_once __DIR__ . "/Permission.php";

class PermissionRepo extends Repo {
    public static string $table = "permissions";

    public function CreateTable(): bool {
        $query = "CREATE TABLE " . static::$table . " (
            id SERIAL PRIMARY KEY,
            name TEXT UNIQUE
        );";
        return pg_exec($this->dbconn, $query) !== false;
    }

    public function New(Permission $permission): PgSql\Result|string|bool {
        return $this->Add(array("name" => $permission->name));
    }
    
    public function instanciate(array $p)
    {
        return new Permission($p["id"], $p["name"]);
    }

    public function GetById(int $id): Permission|null {
        if(!$res = pg_exec($this->dbconn, "SELECT * FROM " . static::$table . " WHERE id = {$id}")) {
            return null;
        }
        $p = pg_fetch_assoc($res);
        return $this->instanciate($p);
    }

    public function GetByName(string $name): Permission|null {
        if(!$res = pg_exec($this->dbconn, "SELECT * FROM " . static::$table . " WHERE name = '{$name}';")) {
            return null;
        }
        $p = pg_fetch_assoc($res);
        return $this->instanciate($p);
    }

    public static function UserIdHasPermission(int $userid, string $permission): bool {
        $query = "SELECT count(*)
            FROM " . static::$table . " as p
            JOIN " . RolesPermissionsRepo::$table . " as rp
                ON rp.permission_id = p.id
            JOIN " . RoleRepo::$table . " as r
                ON rp.role_id = r.id
            JOIN " . UsersRolesRepo::$table . " as ur
                ON ur.role_id = r.id 
            JOIN " . UserRepo::$table . " as u
                ON ur.user_id = u.id 
            WHERE p.name = '{$permission}'
            AND u.id = {$userid}
        ";
        $res = pg_exec(PSQLFactory::getInstance()->connect(), $query);
        if(!pg_fetch_all($res)) {
            return false;
        }
        return true;
    }
}