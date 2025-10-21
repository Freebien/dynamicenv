<?php
(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('cli only');
$POSTGRES_HOST=$_ENV['POSTGRES_HOST'];
$POSTGRES_PORT=intval($_ENV['POSTGRES_PORT']);
$POSTGRES_USER=$_ENV["POSTGRES_USER"];
$POSTGRES_PASSWORD=$_ENV['POSTGRES_PASSWORD'];

$BOX_DB_USER=$_ENV['BOX_DB_USER'];
$BOX_DB_PASS=$_ENV['BOX_DB_PASS'];
$BOX_DB_DB=$_ENV['BOX_DB_DB'];

$BOX_ADMIN_PASSWORD=$_ENV['BOX_ADMIN_PASSWORD'];

include_once __DIR__ . "/../includes/classes/Role.php";
$roles = [
    "admin" => new Role(1, "admin"),
    "moderator" => new Role(2, "moderator"),
    "user" => new Role(3, "user"),
];

include_once __DIR__ . "/../includes/classes/Permission.php";
$permissions = [
    "me/view" => new Permission(1, "me/view"),
    "me/edit" => new Permission(2, "me/edit"),
    "me/delete" => new Permission(3, "me/delete"),
    "users/list" => new Permission(4, "users/list"),
    "users/edit" => new Permission(5, "users/edit"),
    "users/delete" => new Permission(6, "users/delete"),
    "users/create" => new Permission(7, "users/create")
];
    
$roles_permissions = [
    "admin" => [
        "users/list",
        "users/edit",
    ]
];

include_once __DIR__ . "/../includes/classes/User.php";
$users = [
    "box" => new User(1, "box",  password_hash($BOX_ADMIN_PASSWORD, PASSWORD_ARGON2I), "I am a box lover"),
    "bob" => new User(2, "bob", password_hash("bob", CRYPT_MD5), "I think I like someone"),
    "alice" => new User(3, "alice", password_hash("crypto", CRYPT_MD5), "#SYNT{V Ybir Pelcgb}#"),
];

$users_roles = [
    "box" => [
        "admin",
        "moderator",
        "user"
    ],
    "bob" => [
        "moderator",
        "user"
    ],
    "alice" => [
        "user"
    ]
];

include_once __DIR__ . "/../includes/classes/Secret.php";

$secrets = [
    Secret::WithPlaintext($users["box"], "box db", "postgres://{$POSTGRES_USER}:{$POSTGRES_PASSWORD}@{$POSTGRES_HOST}:{$POSTGRES_PORT}/{$BOX_DB_DB}"),
    Secret::WithPlaintext($users["box"], "my password", "{$BOX_ADMIN_PASSWORD}")
];

include_once __DIR__ . "/../includes/classes/Post.php";
$posts = [
    new Post(1, $users["box"],  "New content", "I am happy to annouce the begining of our website. It is a well secured vault ! No need to store your keys somewhere, all you have to do is connect and your secrets will be stored with a good encryption !", strtotime("-1 week +1 day")),
    new Post(2, $users["box"],  "Sorry", "I had a small issue on my end, some tests where in production, so some of your passwords are not hashed as it should ! It is now fixed, so please change your password !", strtotime("-1 week +3 day")),
];

require_once __DIR__ . "/../includes/classes/PSQLFactory.php";

$psqlFactory = new PSQLFactory($POSTGRES_HOST, $POSTGRES_PORT, $BOX_DB_USER, $BOX_DB_PASS, $BOX_DB_DB);

if (!$dbconn = $psqlFactory->connect()) {
    print("could not connect to box db\n");
    exit(1);
}

require_once __DIR__ . "/../includes/classes/UserRepo.php";

$user_repo = UserRepo::getInstance();

if(!$user_repo->CreateTable()) {
    echo "Creating table {${UserRepo::$table}} failed\n";
};

foreach($users as $name => $user) {
    if(!$user_repo->New($user)) {
        echo "Creating user {$user->login} failed\n";
    }
}

require_once __DIR__ . "/../includes/classes/PermissionRepo.php";

$permission_repo = PermissionRepo::getInstance();

if(!$permission_repo->CreateTable()) {
    echo "Creating table {${PermissionRepo::$table}} failed\n";
};

foreach($permissions as $name => $permission) {
    if(!$permission_repo->New($permission)) {
        echo "Creating permission {$permission->name} failed\n";
    }
}

require_once __DIR__ . "/../includes/classes/RoleRepo.php";

$role_repo = RoleRepo::getInstance();

if(!$role_repo->CreateTable()) {
    echo "Creating table {${RoleRepo::$table}} failed\n";
};

foreach($roles as $name => $role) {
    if(!$role_repo->New($role)) {
        echo "Creating role {$role->name} failed\n";
    }
}

require_once __DIR__ . "/../includes/classes/RolesPermissionsRepo.php";

$roles_permissions_repo = RolesPermissionsRepo::getInstance();

if(!$roles_permissions_repo->CreateTable()) {
    echo "Creating table {${RolesPermissionsRepo::$table}} failed\n";
};

foreach($roles_permissions as $role => $role_perms) {
    foreach($role_perms as $perm) {
        echo "$role has $perm\n";
        if(!$roles_permissions_repo->Add(array("role_id" => $roles[$role]->id, "permission_id" => $permissions[$perm]->id))) {
            echo "Inserting permission {$perm} for {$role} failed\n";
        }
    }
}

require_once __DIR__ . "/../includes/classes/UsersRolesRepo.php";
$users_roles_repo = UsersRolesRepo::getInstance();

if(!$users_roles_repo->CreateTable()) {
    echo "Creating table {${UsersRolesRepo::$table}} failed\n";
};

foreach($users_roles as $user => $user_roles) {
    foreach($user_roles as $role) {
        if(!$users_roles_repo->Add(array("user_id" => $users[$user]->id, "role_id" => $roles[$role]->id))) {
            echo "Inserting role {$role} for user {$user} failed\n";
        }
    }
}

require_once __DIR__ . "/../includes/classes/SecretRepo.php";
$secret_repo = SecretRepo::getInstance();
if(!$secret_repo->CreateTable()) {
    echo "Creating table {${SecretRepo::$table}} failed\n";
};

foreach($secrets as $secret) {
    if(!$secret_repo->New($secret)) {
        echo "Inserting secret {$secret->name} failed\n";
    }
}

require_once __DIR__ . "/../includes/classes/PostRepo.php";
$post_repo = PostRepo::getInstance();
if(!$post_repo->CreateTable()) {
    echo "Creating table {${PostRepo::$table}} failed\n";
};
foreach($posts as $post) {
    if(!$post_repo->New($post)) {
        echo "Inserting post {$post->title} failed\n";
    }
}
pg_close($dbconn);

?>
