<?php
session_start();
require_once("../inc/config.php");
$errors = array();
$success = array();
if (!isset($_SESSION["connected"]) || !isset($_SESSION["user"])) {
  http_response_code(401);
  header("Location: /login.php");
  exit(0);
}
if ($_SESSION["user"]->role != "admin") {
  http_response_code(403);
  header("Location: /login.php");
  exit(0);
}
if (!isset($_REQUEST["id"])) {
  http_response_code(404);
  header("Location: index.php");
  exit(0);
}
require_once("../inc/db.php");
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = " . $_REQUEST["id"] . " LIMIT 1");
if ($stmt === false) {
  http_response_code(406);
  header("Location: index.php");
  exit(0);
}
$stmt->execute();
$user = $stmt->fetch();
if ($user === false) {
  http_response_code(404);
  header("Location: index.php");
  exit(0);
}
$title = "User Admin";
include("../inc/header.php");
?>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">User Info</h6>
            </div>
            <div class="card-body">
              <form class="user" method="POST">
                <div class="form-group">
                  <input type="text" name="login" value="<?=$user->login?>" class="form-control form-control-user" aria-describedby="emailHelp" placeholder="Enter Login...">
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control form-control-user" placeholder="Password">
                </div>
                <div class="form-group">
                  <input type="text" name="role" value="<?=$user->role?>" class="form-control form-control-user" aria-describedby="emailHelp" placeholder="User's role">
                </div>
                <button type="submit" disabled class="btn btn-primary btn-user btn-block">
                  Update
                </button>
              </form>
            </div>
          </div>
<?php
include("../inc/footer.php");
