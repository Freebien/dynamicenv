<?php
if ($argc != 2) {
    echo "${argv[0]} <password>";
    exit(1);
}
require_once("inc/db.php");

$pdo->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    login TEXT,
    password TEXT,
    role TEXT
)");

$users = array(
    array(
        "id" => 1,
        "login" => "sbadmin",
        "password" => "${argv[1]}",
        "role" => "admin",
    )
);

$insert = "INSERT OR REPLACE INTO users (id, login, password, role) VALUES (:id, :login, :password, :role)";
$stmt = $pdo->prepare($insert);

$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->bindParam(":login", $login, PDO::PARAM_STR);
$stmt->bindParam(":password", $password, PDO::PARAM_STR);
$stmt->bindParam(":role", $role, PDO::PARAM_STR);

foreach ($users as $user) {
    $id = $user["id"];
    $login = $user["login"];
    $password = $user["password"];
    $role = $user["role"];
    $stmt->execute();
}