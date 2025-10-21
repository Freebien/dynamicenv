<?php

require_once __DIR__ . "/PSQLFactory.php";
require_once __DIR__ . "/RoleRepo.php";
require_once __DIR__ . "/PermissionRepo.php";
require_once __DIR__ . "/RolesPermissionsRepo.php";
require_once __DIR__ . "/UsersRolesRepo.php";
require_once __DIR__ . "/UserRepo.php";


class User {
    public int $id;
    public string $login;
    public string $hash;
    public string $bio;
    public string $key;
    public ?string $avatar;

    public static string|int|null $hash_algo = PASSWORD_ARGON2I;

    public function __construct(int $id, string $login, string $hash, string $bio, ?string $key="", ?string $avatar="") {
        $this->id = $id;
        $this->login = $login;
        $this->bio = $bio;
        $this->hash = $hash;
        $this->avatar = $avatar;
        if ($key === "") {
            $key = md5(openssl_random_pseudo_bytes(32));
        }
        $this->key = $key;
    }

    public function listRoles(): array|Role|null {
        return UsersRolesRepo::ListRolesForUserId($this->id);
    }

    public function hasRole(string $role): bool {
        return UsersRolesRepo::UserIdHasRole($this->id, $role);
    }

    public function hasPermission(string $permission): bool {
        return PermissionRepo::UserIdHasPermission($this->id, $permission);
    }

    public function updatePassword(string $password) {
        $this->hash = password_hash($password, PASSWORD_ARGON2I);
    }
}