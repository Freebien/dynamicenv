<?php

require_once __DIR__ . "/../../includes/config.php";
require_once ROOT_DIR . "/includes/classes/Session.php";

if (!Session::isConnected()) {
    Session::redirectLogin();
}

if (!Session::hasPermission("/users/list")) {
    ?>
    <p>You don't have the rights to view this page</p>
    <?
    return;
}

require_once ROOT_DIR . "/includes/classes/UserRepo.php";

$res = UserRepo::getInstance()->GetAll();

?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Login</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
foreach($res as $user) {
    ?>
        <tr>
            <th scope="row"><?= $user->id ?></td>
            <td><img class="img-fluid rounded-circle" src="<?= $user->avatar ?>" /> <?= $user->login ?></td>
            <td>
                <div class="input-group mb-3">
                    <form method="GET" action="user">
                        <input type="hidden" name="id" value="<?=$user->id?>" />
                        <button class="btn btn-primary" type="submit"><i class="bi-pencil"></i></button>
                    </form>
                    <form method="DELETE" action="user">
                        <input type="hidden" name="id" value="<?=$user->id?>" />
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
