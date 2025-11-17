<?php

namespace Core;

use App\models\User;

class Auth
{
    protected static $user = null;
    protected static string $sessionKey = 'auth_user_id';

    public static function attempt(array $credentials): bool
    {
        if (!isset($credentials['email'], $credentials['password'])) {
            throw new \Exception("Credentials must include email and password");
        }

        $userModel = new User();
        $user = $userModel->find("email = $credentials[email] AND password = $credentials[password]", ['*']);
        $user = $user[0] ?? null;

        if ($user) {
            $_SESSION[self::$sessionKey] = $user['id'];
            self::$user = $userModel->findOne($user['id']);
            return true;
        }

        return false;
    }

    // Get current authenticated user
    public static function user(): ?array
    {
        if (self::$user) {
            return self::$user;
        }

        if (isset($_SESSION[self::$sessionKey])) {
            $userModel = new User();
            self::$user = $userModel->findOne($_SESSION[self::$sessionKey]);
            return self::$user;
        }

        return null;
    }

    // Check if user is logged in
    public static function check(): bool
    {
        return self::user() !== null;
    }

    // Log out the user
    public static function logout()
    {
        unset($_SESSION[self::$sessionKey]);
        self::$user = null;
    }
}
