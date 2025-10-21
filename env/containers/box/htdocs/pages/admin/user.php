<?
require_once __DIR__ . "/../../includes/config.php";
require_once ROOT_DIR . "/includes/classes/Session.php";

if (!Session::isConnected()) {
    Session::redirectLogin();
}

if (!Session::hasPermission("/users/edit")) {
    ?>
    <p>You don't have the rights to view this page</p>
    <?
    return;
}

$title = "Admin - User";

if (!$user = UserRepo::getInstance()->GetById($_GET["id"])) {
    Session::redirectLogin("/admin/list_users");
}

require_once ROOT_DIR . "/includes/classes/UserRepo.php";
require_once ROOT_DIR . "/includes/classes/RoleRepo.php";

?>
<form>
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">@</span>
        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="login" value="<?=$user->login?>">
    </div>

    <div class="input-group mb-3">
        <input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" name="password">
        <input type="password" class="form-control" placeholder="Verify Password" aria-label="Password verify" aria-describedby="basic-addon1" name="password-verify">
    </div>

    <div class="input-group">
        <span class="input-group-text">Bio</span>
        <textarea class="form-control" aria-label="Bio"><?=$user->bio?></textarea>
    </div>
    <div class="mb-3">
        <label for="formFile" class="form-label">Upload your avatar</label>
        <input class="form-control" type="file" name="avatar">
    </div>
    <div class="mb-3">
        <label for="formFile" class="form-label">Roles</label>
        <select class="form-select" multiple aria-label="Default select example">
            <?php foreach(RoleRepo::getInstance()->GetAll() as $role) {
                ?>
                <option value="<?=$role->id?>" <?= UsersRolesRepo::UserIdHasRole($user->id, $role->name) ? "selected" : "" ?>><?= $role->name ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
</form>
