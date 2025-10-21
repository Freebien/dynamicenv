<?

require_once __DIR__ . "/Repo.php";
require_once __DIR__. "/User.php";

class UserRepo extends Repo {
    public static string $table = "users";

    public static string $col_id = "id";
    public static string $col_login = "login";
    public static string $col_hash = "hash";
    public static string $col_bio = "bio";
    
    public function instanciate(array $u)
    {
        return new User($u["id"], $u["login"], $u["hash"], $u["bio"], $u["key"], $u["avatar"]);
    }

    public function CreateTable(): bool {
        $query = "CREATE TABLE " . static::$table . " (
            id SERIAL PRIMARY KEY,
            login TEXT UNIQUE NOT NULL,
            hash TEXT NOT NULL,
            bio TEXT,
            key CHAR(32) NOT NULL,
            avatar TEXT
        );";
        if(!pg_exec($this->dbconn, $query)) {
            return false;
        }
        return true;
    }

    public function New(User $user): PgSql\Result|string|bool {
        return $this->Add(["login" => $user->login, "hash" => $user->hash, "bio" => $user->bio, "key" => $user->key, "avatar" => $user->avatar]);
    }

    public function GetById($id): User|null {
        if(!$res = pg_exec($this->dbconn, "SELECT * FROM " . static::$table . " WHERE id = {$id}")) {
            return null;
        }
        $u = pg_fetch_assoc($res);
        return new User($u["id"], $u["login"], $u["hash"], $u["bio"], $u["key"], $u["avatar"]);
    }

    public function GetByLogin(string $login): User|null {
        $query = "SELECT * FROM " . static::$table . " WHERE login = '{$login}'";
        if(!$res = pg_exec($this->dbconn, $query)) {
            return null;
        }
        if(!$u = pg_fetch_assoc($res)) {
            return null;
        }
        return $this->instanciate($u);
    }

    public function Login(string $login, string $password): User|bool {
        if(!$user = $this->GetByLogin($login)) {
            throw new Exception("user does not exists");
        }
        echo "<!-- pass: $password hash: $user->hash -->";
        if (!password_verify($password, $user->hash)) {
            throw new Exception("password is wrong");
            return false;
        }
        return $user;
    }

    public function Update(User $user): bool {
        return $this->_update(array("login"=>$user->login, "hash"=>$user->hash, "bio"=>$user->bio, "key"=>$user->key, "avatar"=>$user->avatar), array("id"=>$user->id));
    }
}