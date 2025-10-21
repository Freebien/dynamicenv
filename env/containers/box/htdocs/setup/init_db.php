<?php
(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('cli only');
$POSTGRES_HOST=$_ENV['POSTGRES_HOST'];
$POSTGRES_PORT=intval($_ENV['POSTGRES_PORT']);

$POSTGRES_USER=$_ENV["POSTGRES_USER"];
$POSTGRES_PASSWORD=$_ENV['POSTGRES_PASSWORD'];
$POSTGRES_DB=$_ENV['POSTGRES_DB'];

$BOX_DB_USER=$_ENV['BOX_DB_USER'];
$BOX_DB_PASSWORD=$_ENV['BOX_DB_PASS'];
$BOX_DB_DB=$_ENV['BOX_DB_DB'];

require_once __DIR__ . "/../includes/classes/PSQLFactory.php";

$psqlSuperFactory = new PSQLFactory($POSTGRES_HOST, $POSTGRES_PORT, $POSTGRES_USER, $POSTGRES_PASSWORD, $POSTGRES_DB);

if (!$dbconn = $psqlSuperFactory->connect()) {
    echo "Could not connect to psql://{$POSTGRES_HOST}:{$POSTGRES_PORT}/{$POSTGRES_DB}\n";
    exit(1);
}
if(!pg_query($dbconn, "CREATE USER {$BOX_DB_USER} WITH ENCRYPTED PASSWORD '{$BOX_DB_PASSWORD}';")) {
    echo "Creating user failed\n";
    exit(1);
};
echo "[OK] Creating user\n";

if(!pg_query($dbconn, "CREATE DATABASE {$BOX_DB_DB} WITH OWNER {$BOX_DB_USER};")) {
    echo "Creating database failed\n";
    exit(1);
};
echo "[OK] Creating database\n";

pg_close($dbconn);
