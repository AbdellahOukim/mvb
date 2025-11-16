<?php

namespace Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $pdo = null;

    public static function connect(): PDO
    {
        if (self::$pdo) return self::$pdo;
        $host = env('DB_HOST');
        $db   = env('DB_NAME');
        $user = env('DB_USER');
        $pass = env('DB_PASS');
        $port = env('DB_PORT') ?? 3306;
        $dsn = "mysql:host=$host;dbname=$db;port=$port;charset=utf8mb4";

        try {
            self::$pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die("DB Connection error: " . $e->getMessage());
        }

        return self::$pdo;
    }
}
