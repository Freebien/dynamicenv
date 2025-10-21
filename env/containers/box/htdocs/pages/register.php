<?php
$title = "Login";

require_once __DIR__ . "/../includes/config.php";
require_once ROOT_DIR . "/includes/classes/UserRepo.php";
function register(string $login, string $password, string $password_verify): bool|string {
    if(strcmp($password, $password_verify) !== 0) {
        http_response_code(400);
        return "passwords don't match";
    }
    $u = new User(0, $login, password_hash($password, User::$hash_algo), "");
    if (!UserRepo::getInstance()->New($u)) {
        return "something went wrong";
    }
    return true;
}

if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['password_verify'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $password_verify = $_POST['password_verify'];

    $res = register($login, $password, $password_verify);
    if($res === true) {
        http_response_code(302);
        if(isset($_GET["next_page"])) {
            header("Location: {$_GET["next_page"]}");
            return;
        }
        header("Location: /login");
        return;
    } else {
        http_response_code(401);
        array_push($alerts, ["type" => "error", "message" => $res]);
    }
}
?>
<form method="POST">
    <h1 class="h3 mb-3 fw-normal">Please register</h1>

    <div class="form-floating">
      <input type="text" class="form-control" id="floatingInput" placeholder="Login" name="login">
      <label for="floatingInput">Username</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
      <label for="floatingPassword">Password</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Verify Password" name="password_verify">
      <label for="floatingPassword">Password Verify</label>
    </div>
    <button class="btn btn-primary w-100 py-2" type="submit">Register</button>
  </form>