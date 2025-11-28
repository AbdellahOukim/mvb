<?php

namespace Core;

use App\models\User;

class Auth
{
    protected static $user = null;
    protected static string $sessionKey = 'id_user';

    public static function attempt(array $credentials): bool
    {
        if (!isset($credentials['email'], $credentials['password'])) {
            return false;
        }

        $userModel = new User();
        $user = $userModel->find()->where("email = '{$credentials['email']}'")->first();
        if ($user && password_verify($credentials['password'], $user['password'])) {
            setLang("fr");
            $_SESSION[self::$sessionKey] = $user['id'];
            self::$user = $userModel->findOne($user['id']);
            return true;
        }

        return false;
    }

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

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function logout()
    {
        unset($_SESSION[self::$sessionKey]);
        self::$user = null;
    }
}
