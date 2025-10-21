<?php

$title = "Blog";

require_once __DIR__ . "/../includes/config.php";
require_once ROOT_DIR . "/includes/classes/PostRepo.php";
$page = isset($_GET["page"]) ? intval($_GET["page"]): 0;
$limit = isset($_GET["limit"]) ? intval($_GET["limit"]): 10;
$order_by = "date";

$posts = PostRepo::getInstance()->Search(isset($_GET["search"]) ? $_GET["search"] : "", $limit, $page);

?>
<div class="row g-5">
    <div class="col-md-6">
        <ul class="list-unstyled ps-0">
            <?php
            foreach($posts as $post) {
                ?>
            <li>
                <a class="icon-link mb-1" href="/post?id=<?= $post->id ?>" rel="noopener" target="_blank">
                    <?= $post->title ?>
                </a>  by <?= $post->user->login ?> the <?= date(DATE_RFC2822, $post->date) ?>
            </li>
                <?
            }
            ?>
        </ul>
    </div>
</div>