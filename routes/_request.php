<?php

use App\Http\Controllers\Admin\RequestJsController;

Route::controller(RequestJsController::class)->middleware(['auth'])->prefix('js')->name('js.')->group(function () {
    Route::post('/slug', 'slug')->name('slug');
    Route::post('/get_images', 'get_images')->name('get_images');
});
