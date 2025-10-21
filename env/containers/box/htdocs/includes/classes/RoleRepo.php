<?php

require_once __DIR__ . "/Repo.php";
require_once __DIR__ . "/Role.php";

class RoleRepo extends Repo {
    public static string $table = "roles";

    public function CreateTable(): bool {
        $query = "CREATE TABLE " . static::$table . " (
            id SERIAL PRIMARY KEY,
            name TEXT UNIQUE
        );";
        return pg_exec($this->dbconn, $query) !== false;
    }

    public function instanciate(array $res) {
        return new Role($res["id"], $res["name"]);
    }

    public function New(Role $role): PgSql\Result|string|bool {
        return $this->Add(array("name" => $role->name));
    }

    public function GetById(int $id): Role|null {
        if(!$res = pg_exec($this->dbconn, "SELECT * FROM " . static::$table . " WHERE id = {$id}")) {
            return null;
        }
        $p = pg_fetch_assoc($res);
        return $this->instanciate($p);
    }

    public function GetByName(string $name): Role|null {
        if(!$res = pg_exec($this->dbconn, "SELECT * FROM " . static::$table . " WHERE name = '{$name}';")) {
            return null;
        }
        $p = pg_fetch_assoc($res);
        return $this->instanciate($p);
    }

}
