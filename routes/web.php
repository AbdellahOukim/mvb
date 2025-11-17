
<?php

use Core\Route;
use App\controllers\HomeController;

Route::middleware("auth", function () {
    Route::make('/', HomeController::class);
});
