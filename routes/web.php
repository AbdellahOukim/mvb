
<?php

use Core\Route;
use App\controllers\HomeController;

setLang('fr');
Route::make('/', HomeController::class);
