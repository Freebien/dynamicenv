<?php

define("ROOT_DIR", __DIR__ . "/..");

define("DB_HOST", getenv("BOX_DB_HOST") ?: "db");
define("DB_PORT", getenv("BOX_DB_PORT") ?: 5432);
define("DB_USER", getenv("BOX_DB_USER") ?: "box");
define("DB_PASS", getenv("BOX_DB_PASS") ?: "box");
define("DB_DB",   getenv("BOX_DB_DB")   ?: "box");

define("UPLOAD_DIR", "/assets/uploads");

?>