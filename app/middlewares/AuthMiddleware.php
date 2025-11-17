<?php

namespace App\middlewares;

use Core\Auth;

class AuthMiddleware
{
    public function handle()
    {
        $isAuth = Auth::check();
        if (!$isAuth) {
            echo "Unautorized";
            exit;
        }
    }
}
