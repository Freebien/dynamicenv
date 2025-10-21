<?php
$title = "Login";

require_once __DIR__ . "/../includes/config.php";
require_once ROOT_DIR . "/includes/classes/UserRepo.php";
function login(string $login, string $password): bool|string {
    try {
        $user = UserRepo::getInstance()->Login($login, $password);
    } catch (Exception $e) {
        return $e->getMessage();
    }
    return Session::setUser($user);
}

if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $res = login($login, $password);
    if($res === true) {
        http_response_code(302);
        if(isset($_GET["next_page"])) {
            header("Location: {$_GET["next_page"]}");
            return;
        }
        header("Location: /");
        return;
    } else {
        http_response_code(401);
        array_push($alerts, ["type" => "error", "message" => $res]);
    }
}
?>

<form method="POST">
    <h1 class="h3 mb-3 fw-normal">Please login</h1>

    <div class="form-floating">
      <input type="text" class="form-control" id="floatingInput" placeholder="Login" name="login">
      <label for="floatingInput">Username</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
      <label for="floatingPassword">Password</label>
    </div>
    <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
    <a href="/register">Don't have an account yet ?</a>
  </form>