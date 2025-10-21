<?
require_once __DIR__ . "/../includes/config.php";
require_once ROOT_DIR . "/includes/classes/Session.php";
require_once ROOT_DIR . "/includes/classes/User.php";
if (!Session::isConnected()) {
    Session::redirectLogin();
}

if (empty($_GET["id"])) {
    Session::redirectLogin();
}

$user = UserRepo::getInstance()->GetById($_GET["id"]);

if(!$user) {
    Session::redirectLogin();
}

$secrets = SecretRepo::getInstance()->GetAllForUserId($user->id);
$roles = UsersRolesRepo::ListRolesForUserId($user->id);

?>
<form method="POST" enctype="multipart/form-data">
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">@</span>
        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="login" value="<?=$user->login?>" disabled>
    </div>

    <div class="input-group mb-3">
        <input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" name="password">
        <input type="password" class="form-control" placeholder="Verify Password" aria-label="Password verify" aria-describedby="basic-addon1" name="password-verify">
    </div>

    <div class="input-group">
        <span class="input-group-text">Bio</span>
        <textarea class="form-control" aria-label="Bio" name="bio"></textarea>
    </div>

    <div class="mb-3">
        <label for="formFile" class="form-label">Upload your avatar</label>
        <input class="form-control" type="file" name="avatar">
    </div>

    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
</form>
