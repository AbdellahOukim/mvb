<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../routes/web.php';
require __DIR__ . '/../core/helpers.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

use Core\Route;

Route::dispatch();
