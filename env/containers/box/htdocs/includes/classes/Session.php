<?php

session_start();

require_once __DIR__ . "/User.php";

class Session {
    private static string $userKeyName = "user";
    
    public static function isConnected(): bool {
        return isset($_SESSION[self::$userKeyName]);
    }
    
    public static function hasPermission(string $permission): bool {
        if(!$user = self::getUser()) {
            return false;
        }
        return $user->hasPermission($permission);
    }
    
    public static function getUser(): User|null {
        if (!isset($_SESSION[self::$userKeyName])) {
            return null;
        }

        return unserialize($_SESSION[self::$userKeyName]);
    }

    public static function setUser(User $user): bool {
        $_SESSION[self::$userKeyName] = serialize($user);
        return true;
    }

    public static function disconnect() {
        session_destroy();
        self::redirectLogin("/");
    }

    public static function redirectLogin(string $location="") {
        if($location != "") {
            header("Location: $location");
        } else {
            header("Location: /login?next_url={$_GET['page']}");
        }
        http_response_code(302);
        die();
    }
}
