<?php

require_once __DIR__ . "/PSQLFactory.php";
require_once __DIR__ . "/User.php";

class Permission {
    public int $id;
    public string $name;
    
    public function __construct(int $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }
}