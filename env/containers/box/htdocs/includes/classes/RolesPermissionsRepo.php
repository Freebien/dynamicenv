<?

require_once __DIR__ . "/Repo.php";
require_once __DIR__ . "/RoleRepo.php";
require_once __DIR__ . "/PermissionRepo.php";
require_once __DIR__ . "/Permission.php";

class RolesPermissionsRepo extends Repo {
    public static string $table = "roles_permissions";
    
    public function CreateTable(): bool {
        $query = "CREATE TABLE " . static::$table . " (
            role_id INTEGER REFERENCES " . RoleRepo::$table . "(id),
            permission_id INTEGER REFERENCES " . PermissionRepo::$table . "(id)
        );";
        return pg_exec($this->dbconn, $query) !== false;
    }

    public static function ListPermissionsForRoleId(int $role_id): array {
        $query = "SELECT p.id as id, p.name as name
            FROM " . static::$table . " as rp
            JOIN " . RoleRepo::$table . " as r
                ON rp.role_id = r.id
            JOIN " . PermissionRepo::$table . " as r
                ON rp.permission_id = p.id
            WHERE r.id = '{$role_id}'
        ";
        $ret = array();
        $res = pg_exec(PSQLFactory::getInstance()->connect(), $query);
        foreach(pg_fetch_all($res, PGSQL_ASSOC) as $data) {
            array_push($ret, new Permission($data["id"], $data["name"]));
        }
        return $ret;
    }
    public static function RoleHasPermission(int $role_id, string $permission): bool {
        $query = "SELECT *
            FROM " . static::$table . " as rp
            JOIN " . PermissionRepo::$table . " as p
                ON p.id = rp.permission_id
            WHERE rp.role_id = $role_id
            AND p.name = '{$permission}';
        ";
        $res = pg_exec(PSQLFactory::getInstance()->connect(), $query);
        if(!pg_fetch_all($res)) {
            return false;
        }
        return true;
    }
}
