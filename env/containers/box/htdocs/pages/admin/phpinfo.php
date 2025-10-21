<?

require_once __DIR__ . "/../../includes/config.php";
require_once ROOT_DIR . "/includes/classes/Session.php";

if (!Session::isConnected() && Session::hasPermission("/admin/phpinfo")) {
    Session::redirectLogin();
}

phpinfo();
?>