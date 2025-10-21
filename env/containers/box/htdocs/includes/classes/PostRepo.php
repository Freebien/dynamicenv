<?php

require_once __DIR__ . "/Post.php";
require_once __DIR__ . "/UserRepo.php";

class PostRepo extends Repo {
    public static string $table = "posts";

    public function CreateTable(): bool {
        $query = "CREATE TABLE " . static::$table . " (
            id SERIAL PRIMARY KEY,
            user_id INTEGER REFERENCES " . UserRepo::$table . "(id),
            title TEXT UNIQUE,
            content TEXT,
            date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );";
        return pg_exec($this->dbconn, $query) !== false;
    }

    public function instanciate(array $p)
    {
        $u = UserRepo::getInstance()->GetById($p["user_id"]);
        if (!$u) {
            return null;
        }
        return new Post($p["id"], $u, $p["title"], $p["content"], strtotime($p["date"]));
    }

    public function New(Post $post): PgSql\Result|string|bool {
        return $this->Add(array("user_id" => $post->user->id, "title" => $post->title, "content" => $post->content, "date" => date(DATE_ATOM, $post->date)));
    }

    public function GetById(string $id): Post|null {
        if(!$res = pg_exec($this->dbconn, "SELECT * FROM " . static::$table . " WHERE id = {$id}")) {
            return null;
        }
        if(!$p = pg_fetch_assoc($res)) {
            return null;
        }
        return $this->instanciate($p);
    }

    public function Search(string $search, int $limit=10, int $offset=0): array|null {
        $query = "SELECT * FROM " . static::$table;
        if ($search) $query .= " WHERE title LIKE '%{$search}%' OR content LIKE '%{$search}%'";
        $query .= " ORDER BY date DESC LIMIT {$limit} OFFSET {$offset};";
        if(!$res = pg_exec($this->dbconn, $query)) {
            return null;
        }
        $posts = array();
        foreach(pg_fetch_all($res, PGSQL_ASSOC) as $p) {
            if (!$post = $this->instanciate($p)) continue;
            array_push($posts, $post);
        }
        return $posts;
    }

}
