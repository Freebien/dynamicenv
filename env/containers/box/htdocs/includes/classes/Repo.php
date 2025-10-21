<?php

abstract class Repo {
    public ?PgSql\Connection $dbconn;
    public static string $table;
    protected static $_instances = [];
    protected function __construct(PgSql\Connection $dbconn) {
        $this->dbconn = $dbconn;
    }

    public function instanciate(array $res) {
        return null;
    }

    public function Add(array $values): PgSql\Result|string|bool {
        return pg_insert($this->dbconn, $this::$table, $values);
    }

    public function GetAll(int $offset=0, int $limit=10, string $order_by="", bool $asc=true): array|null {
        $query = "SELECT * FROM ". static::$table;
        if ($order_by !== "") {
            $query .= " ORDER BY {$order_by} " . ($asc ? "ASC" : "DESC");
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
        $arr = array();
        foreach(pg_fetch_all($res, PGSQL_ASSOC) as $p) {
            array_push($arr, $this->instanciate($p));
        }
        return $arr;
    }

    protected function _update(array $values, array $conditions): bool {
        if(! pg_update($this->dbconn, static::$table, $values, $conditions)) {
            return false;
        }
        return true;
    }

    public static function getInstance(): static {
        if(empty($_instances[static::class])) {
            $_instances[static::class] = new static(PSQLFactory::getInstance()->connect());
        }
        return $_instances[static::class];
    }
    final protected function __clone()
    {
    }
}