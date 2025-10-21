<?

require_once __DIR__ . "/Repo.php";
require_once __DIR__ . "/UserRepo.php";
require_once __DIR__ . "/RoleRepo.php";

class UsersRolesRepo extends Repo {
    public static string $table = "users_roles";

    public function CreateTable(): bool {
        if(!pg_exec($this->dbconn, "CREATE TABLE " . static::$table . " (
            user_id INTEGER REFERENCES " . UserRepo::$table . "(id),
            role_id INTEGER REFERENCES " . RoleRepo::$table . "(id)
        );")) {
            return false;
        }
        return true;
    }

    public static function ListRolesForUserId(int $user_id): array {
        $query = "SELECT id, name
            FROM " . static::$table . "
            RIGHT OUTER JOIN " . RoleRepo::$table . "
                ON " . RoleRepo::$table . ".id = " . static::$table . ".role_id
            WHERE " . static::$table . ".user_id = $user_id
        ";
        $res = pg_exec(PSQLFactory::getInstance()->connect(), $query);
        if(!$res) {
            return null;
        }
        $roles = array();
        foreach(pg_fetch_all($res, PGSQL_ASSOC) as $res) {
            array_push($roles, new Role($res["id"], $res["name"]));
        };
        return $roles;
    }

    public static function UserIdHasRole(int $user_id, string $role): bool {
        $query = "SELECT *
            FROM " . static::$table . " as ru
            JOIN " . RoleRepo::$table . " as r
                ON r.id = ru.role_id
            WHERE ru.user_id = $user_id
            AND r.name = '{$role}';
        ";
        $res = pg_exec(PSQLFactory::getInstance()->connect(), $query);
        if(!pg_fetch_all($res)) {
            return false;
        }
        return true;
    }
}
