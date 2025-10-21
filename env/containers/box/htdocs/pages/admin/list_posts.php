<?php

require_once __DIR__ . "/../../includes/config.php";
require_once ROOT_DIR . "/includes/classes/Session.php";

if (!Session::isConnected()) {
    Session::redirectLogin();
}

require_once ROOT_DIR . "/includes/classes/PostRepo.php";

$res = PostRepo::getInstance()->GetAll();

?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Title</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
foreach($res as $post) {
    ?>
        <tr>
            <th scope="row"><?= $post->id ?></td>
            <td><?= $post->title ?></td>
            <td>
                <div class="input-group mb-3">
                    <form method="GET" action="post">
                        <input type="hidden" name="id" value="<?=$post->id?>" />
                        <button class="btn btn-primary" type="submit"><i class="bi-pencil"></i></button>
                    </form>
                    <form method="DELETE" action="post">
                        <input type="hidden" name="id" value="<?=$post->id?>" />
                        <button name="" class="btn btn-danger" type="submit"><i class="bi-trash"></i></button>
                    </form>
                </div>
            </td>
        </tr>
<?php
}
?>
    </tbody>
</table>
<?php
