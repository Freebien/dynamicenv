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

require_once ROOT_DIR . "/includes/classes/RoleRepo.php";
require_once ROOT_DIR . "/includes/classes/PermissionRepo.php";

$permissions = PermissionRepo::getInstance()->GetAll();

?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Name</th>
            <th scope="col">Permissions</th>
        </tr>
    </thead>
    <tbody>
        <?php
foreach(RoleRepo::getInstance()->GetAll() as $role) {
    ?>
        <tr>
            <th scope="row"><?= $role->id ?></td>
            <td><?= $role->name ?></td>
            <td>
                <select class="form-select" multiple aria-label="Default select example">
            <?php foreach($permissions as $permission) {
                ?>
                    <option value="<?=$permission->id?>" <?= RolesPermissionsRepo::RoleHasPermission($role->id, $permission->name) ? "selected" : "" ?>><?= $permission->name ?></option>
                <?php
            }
            ?>
                </select>
            <td>
                <div class="input-group mb-3">
                    <form method="GET" action="user">
                        <input type="hidden" name="id" value="<?=$role->name?>" />
                        <button class="btn btn-primary" type="submit"><i class="bi-pencil"></i></button>
                    </form>
                    <form method="DELETE" action="user">
                        <input type="hidden" name="id" value="<?=$role->id?>" />
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
