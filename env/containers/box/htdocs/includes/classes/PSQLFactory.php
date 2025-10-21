<?

require_once __DIR__ . "/../config.php";

class PSQLFactory {
    private static ?PSQLFactory $_instance = NULL;
    private string $DB_HOST;
    private int $DB_PORT;

    private string $DB_USER;
    private string $DB_PASS;
    private string $DB_DB;

    public function __construct(string $host, int $port, string $user, string $pass, string $db) {
        $this->DB_HOST = $host;
        $this->DB_PORT = $port;

        $this->DB_USER = $user;
        $this->DB_PASS = $pass;
        $this->DB_DB = $db;
        if( self::$_instance == null) {
            self::$_instance = $this;
        }
    }

    public function connect(): PgSql\Connection|false  {
        $dbconn = "host={$this->DB_HOST} port={$this->DB_PORT} dbname={$this->DB_DB} user={$this->DB_USER} password={$this->DB_PASS}";
        return pg_connect($dbconn);
    }

    public static function getInstance() {
        if (self::$_instance == NULL) {
            self::$_instance = new self(DB_HOST, DB_PORT, DB_USER, DB_PASS, DB_DB);
        }
        return self::$_instance;
    }
}
