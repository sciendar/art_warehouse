<?php

use App\Http\Controllers\IndexController;

Auth::routes([
    'register' => false,
]);

Route::get('', [IndexController::class, 'home'])->name('home');

require('_admin.php');
require('_clear.php');
