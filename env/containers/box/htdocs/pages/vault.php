<?
require_once __DIR__ . "/../includes/config.php";
require_once ROOT_DIR . "/includes/classes/Session.php";

if (!Session::isConnected() || !$user = Session::getUser()) {
    Session::redirectLogin();
}

$title = "Vault";

require_once ROOT_DIR . "/includes/classes/SecretRepo.php";

if(isset($_POST["create"])) {
    $name = $_POST["name"];
    $secret = $_POST["secret"];
    SecretRepo::getInstance()->New(Secret::WithPlaintext($user, $name, $secret));
}

$secrets = SecretRepo::getInstance()->GetAllForUserId($user->id);

?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Name</th>
            <th scope="col">Secret</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
foreach($secrets as $secret) {
    ?>
        <tr>
            <th scope="row"><?= $secret->id ?></td>
            <td><?= $secret->name ?></td>
            <td><?= $secret->Decrypt($user) ?></td>
            <td>
                <div class="input-group mb-3">
                    <form method="GET" action="user">
                        <input type="hidden" name="id" value="<?= $secret->id ?>" />
                        <button class="btn btn-primary" type="submit"><i class="bi-pencil"></i></button>
                    </form>
                    <form method="DELETE" action="user">
                        <input type="hidden" name="id" value="<?= $secret->id ?>" />
                        <button name="" class="btn btn-danger" type="submit"><i class="bi-trash"></i></button>
                    </form>
                </div>
            </td>
        </tr>
<?php
}
?>
        <form method="POST">
            <tr>
                <td>Add</td>
                <td><input type="text" name="name" placeholder="Name"/></td>
                <td><input type="password" name="secret" placeholder="Password"/></td>
                <td><button name="create" class="btn">Create</button></td>
            </tr>
        </form>
    </tbody>
</table>
<?php

