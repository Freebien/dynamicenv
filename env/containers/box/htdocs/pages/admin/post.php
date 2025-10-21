<?
require_once __DIR__ . "/../../includes/config.php";
require_once ROOT_DIR . "/includes/classes/Session.php";

if (!Session::isConnected()) {
    Session::redirectLogin();
}

if (!Session::hasPermission("/posts/edit")) {
    ?>
    <p>You don't have the rights to view this page</p>
    <?
    return;
}

$title = "Admin - Post";

require_once ROOT_DIR . "/includes/classes/PostRepo.php";

if (isset($_GET["id"])) {
    $post = PostRepo::getInstance()->GetById($_GET["id"]);
    if (!$post) {
        Session::redirectLogin("/admin/list_posts");
    }
} else {
    $post = new Post(0, Session::getUser(), "", "");
}

?>
<form>
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Title" aria-label="Title" aria-describedby="basic-addon1" name="title" value="<?=$post->title?>">
    </div>

    <div class="input-group">
        <span class="input-group-text">Content</span>
        <textarea class="form-control" aria-label="Content"><?=$post->content?></textarea>
    </div>
</form>
