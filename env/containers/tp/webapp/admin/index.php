<?php
session_start();
require_once("../inc/config.php");
$errors = array();
$success = array();
$title = "Admin Panel";
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
include("../inc/header.php");
?>
          
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Users</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Login</th>
                      <th>Role</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Login</th>
                      <th>Role</th>
                    </tr>
                  </tfoot>
                  <tbody>
<?php
require_once("../inc/db.php");
$stmt = $pdo->prepare("SELECT id, login, role FROM users");
$stmt->execute();
foreach($stmt->fetchAll() as $user){
?>
                    <tr>
                      <td><a href="user.php?id=<?=$user->id?>"><?=$user->login?></a></td>
                      <td><?=$user->role?></td>
                    </tr>
<?php
}
?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

<?php
include("../inc/footer.php");