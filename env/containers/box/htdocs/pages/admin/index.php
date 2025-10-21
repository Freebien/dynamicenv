<?
require_once __DIR__ . "/../../includes/config.php";
require_once ROOT_DIR . "/includes/classes/Session.php";

if (!Session::isConnected()) {
    Session::redirectLogin();
}

$title = "Admin";

?>
<div class="list-group">
    <a class="list-group-item list-group-item-action" href="list_users">List users</a>
    <a class="list-group-item list-group-item-action" href="list_roles">List roles</a>
    <a class="list-group-item list-group-item-action" href="list_posts">List posts</a>
    <a class="list-group-item list-group-item-action" href="system">System</a>
    <a class="list-group-item list-group-item-action" href="phpinfo">Infos</a>
</div>