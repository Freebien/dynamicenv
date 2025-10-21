<?php

$title = "Post";

require_once __DIR__ . "/../includes/config.php";
require_once ROOT_DIR . "/includes/classes/PostRepo.php";
$page = isset($_GET["page"]) ? intval($_GET["page"]): 0;
$limit = isset($_GET["limit"]) ? intval($_GET["limit"]): 10;
$order_by = "date";

$post = PostRepo::getInstance()->GetById($_GET["id"]);

?>
<div class="row g-5">
    <h2><?= $post->title ?></h2>
    <div class="col-md-6">
        <p><?= $post->content ?></p>
        <p><a href="/user?id=<?= $post->user->id ?>"><?= $post->user->login ?></a> the <?= date(DATE_RFC2822, $post->date) ?></p>
    </div>
</div>