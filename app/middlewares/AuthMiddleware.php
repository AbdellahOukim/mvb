<?php

namespace App\middlewares;

class AuthMiddleware
{
    public function handle()
    {
        $isAuth = true;
        if ($isAuth) {
            echo "Unautorized";
            exit;
        }
    }
}
