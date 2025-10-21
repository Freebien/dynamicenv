<?php

$page = __DIR__ . "/pages/";
$page .= isset($_GET['page']) ? $_GET['page'] : 'start.php';

if (str_ends_with($page, "/")) {
    $page .= "index.php";
}

if (!str_ends_with($page, '.php')) {
    if (file_exists("{$page}.php")) {
        $page .= ".php";
    }
}

if (!file_exists($page)) {
    var_dump("not exists");
    die();
}

require_once __DIR__ . "/includes/config.php";
require_once ROOT_DIR . "/includes/classes/Session.php";

$isApi = false;
$alerts = array();
ob_start();
include_once $page;
$content = ob_get_clean();

if ($isApi) {
    echo $content;
    return;
}

include_once __DIR__ . "/includes/header.php";

foreach ($alerts as $alert) {
    ?>
    <div class="alert alert-dismissible alert-<?=$alert["type"]?>" role="alert">
        <?=$alert["message"]?>
    </div>
    <?php
}
echo $content;

include_once __DIR__ . "/includes/footer.php";