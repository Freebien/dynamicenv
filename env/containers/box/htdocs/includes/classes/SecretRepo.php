<?

use PgSql\Result;

require_once __DIR__ . "/Repo.php";
require_once __DIR__. "/User.php";
require_once __DIR__. "/UserRepo.php";
require_once __DIR__. "/Secret.php";

class SecretRepo extends Repo {
    public static string $table = "secret";

    public function CreateTable(): bool {
        $query = "CREATE TABLE " . static::$table . " (
            id SERIAL PRIMARY KEY,
            user_id INTEGER REFERENCES " . UserRepo::$table . "(id),
            name TEXT NOT NULL,
            secret TEXT NOT NULL,
            UNIQUE (user_id, name)
        );";
        return pg_exec($this->dbconn, $query) !== false;
    }

    public function instanciate(array $p)
    {
        return new Secret($p["id"], $p["user_id"], $p["name"], $p["secret"]);
    }

    public function New(Secret $secret): PgSql\Result|string|bool {
        return $this->Add(["user_id" => $secret->user_id, "name" => $secret->name,  "secret" => $secret->secret]);
    }

    public function GetById(int $id): Secret|null {
        if(!$res = pg_exec($this->dbconn, "SELECT * FROM " . static::$table . " WHERE id = {$id}")) {
            return null;
        }
        $p = pg_fetch_assoc($res);
        return new Secret($p["id"], $p["user_id"], $p["name"], $p["secret"]);
    }

    public function GetByNameForUser(User $user, string $name): Secret|null {
        if(!$res = pg_exec($this->dbconn, "SELECT * FROM " . static::$table . " WHERE user_id = {$user->id} name = '{$name}';")) {
            return null;
        }
        $p = pg_fetch_assoc($res);
        return $this->instanciate($p);
    }

    public function GetAllForUserId(int $user_id, int $offset = 0, int $limit = 10, string $order = ""): array {
        $query = "SELECT * FROM " . static::$table . " WHERE user_id = {$user_id}";
        if ($order !== "") {
            $query .= " ORDER BY {$order}";
        }
        if ($limit > 0) {
            $query .= " LIMIT {$limit}";
        }
        if ($offset > 0) {
            $query .= " OFFSET {$offset}";
        } 
        if(!$res = pg_exec($this->dbconn, $query)) {
            return null;
        }
        $ret = array();
        foreach(pg_fetch_all($res, PGSQL_ASSOC) as $secret) {
            array_push($ret, $this->instanciate($secret));
        }
        return $ret;
    }
}