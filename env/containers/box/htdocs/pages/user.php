<?
require_once __DIR__ . "/../includes/config.php";
require_once ROOT_DIR . "/includes/classes/Session.php";
require_once ROOT_DIR . "/includes/classes/User.php";
if (!Session::isConnected()) {
    Session::redirectLogin();
}

function processPost() {
    global $error;
    if(!isset($_POST["submit"])) {
        return;
    }
    if(!$user = Session::getUser()) {
        return false;
    }
    if(!empty($_POST["password"]) && !empty($_POST["password_verify"])) {
        if ($_POST["password"] !== "" && $_POST["password"] !== $_POST["password_verify"]) {
            array_push($error, "password verify is not good");
            return;
        }
        $pass = $_POST["password"];
        $user->updatePassword($pass);
    }

    if(!empty($_POST["bio"])) {
        $user->bio = $_POST["bio"];
    }

    var_dump($_FILES);
    if (isset($_FILES["avatar"]) && $_FILES["avatar"]["size"] > 0) {
        var_dump($_FILES);
        $target_file = UPLOAD_DIR . "/" . $_FILES["avatar"]["name"];
        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], ROOT_DIR . $target_file)) {
            echo "The file ". $_FILES["avatar"]["name"] . " has been uploaded to {$target_file}";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
        $user->avatar = $target_file;
    }

    UserRepo::getInstance()->Update($user);
    Session::setUser($user);
}

processPost();

if(isset($_GET["id"])) {
    $user = UserRepo::getInstance()->GetById($_GET["id"]);
    $title = "User - {$user->login}";
} else {
    $user = Session::getUser();
    $title = "My info";
}

?>
<form method="POST" enctype="multipart/form-data">
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">@</span>
        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="login" value="<?=$user->login?>" disabled>
    </div>
    <?php
        if (!isset($_GET["id"])) {
            ?>
    <div class="input-group mb-3">
        <input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" name="password">
        <input type="password" class="form-control" placeholder="Verify Password" aria-label="Password verify" aria-describedby="basic-addon1" name="password-verify">
    </div>
            <?php
        }
    ?>
    <div class="input-group">
        <span class="input-group-text">Bio</span>
        <textarea class="form-control" aria-label="Bio" name="bio" <?= isset($_GET["id"]) ? "disabled" : "" ?>><?=$user->bio?></textarea>
    </div>
    <?php
        if (!isset($_GET["id"])) {
            ?>
    <div class="mb-3">
        <label for="formFile" class="form-label">Upload your avatar</label>
        <input class="form-control" type="file" name="avatar">
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            <?php
        }
    ?>
</form>
