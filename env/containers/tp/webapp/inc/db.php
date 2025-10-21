<?php

require_once("config.php");

if (isset($CONF["DB"]["user"]) && isset($CONF["DB"]["password"])) {
    $pdo = new PDO($CONF["DB"]["dsn"], $CONF["DB"]["user"], $CONF["DB"]["password"]);
}else{
    $pdo = new PDO($CONF["DB"]["dsn"]);
}
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);