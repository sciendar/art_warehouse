<?php

use App\Http\Controllers\Admin\ConditionAdminController;
use App\Http\Controllers\Admin\CountryAdminController;
use App\Http\Controllers\Admin\ImageAdminController;
use App\Http\Controllers\Admin\IndexAdminController;
use App\Http\Controllers\Admin\IpAdminController;
use App\Http\Controllers\Admin\JobAdminController;
use App\Http\Controllers\Admin\LogAdminController;
use App\Http\Controllers\Admin\MessageAdminController;
use App\Http\Controllers\Admin\PaintingAdminController;
use App\Http\Controllers\Admin\ParserAdminController;
use App\Http\Controllers\Admin\RoleAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\VisitAdminController;
use App\Http\Controllers\Admin\WarehouseAdminController;
use App\Http\Controllers\Auth\LoginController;

require('_request.php');

Route::get('/admin_login', [IndexAdminController::class, 'login'])->name('admin.login');

Route::group([
    'middleware' => ['auth'],
    'prefix' => 'adminex',
    'as' => 'admin.'
], function () {
    if (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && $_SERVER['HTTP_CF_CONNECTING_IP'] === '176.105.197.23') {
        \Debugbar::enable();
    }

    Route::get('auth', [IndexAdminController::class, 'auth'])->name('auth');
    Route::post('post_auth', [IndexAdminController::class, 'post_auth'])->name('post_auth');

    Route::group([
        'middleware' => ['is_admin']
    ], function () {
        Route::controller(IndexAdminController::class)->group(function () {
            Route::get('', 'home')->name('home');
            Route::get('test', 'test')->name('test');
            Route::post('change_warehouse', 'change_warehouse')->name('change_warehouse');
        });

        Route::resource('paintings', PaintingAdminController::class);
        Route::resource('warehouses', WarehouseAdminController::class);

        Route::resource('images', controller: ImageAdminController::class);
        Route::controller(ImageAdminController::class)->name('images.')->group(function () {
            Route::post('rotate/{image}', 'rotate')->name('rotate');

        });

        // Сообщения
        Route::resource('messages', MessageAdminController::class);

        // Сущности
        Route::resource('roles', RoleAdminController::class);
        Route::resource('ips', IpAdminController::class);

        Route::resource('users', UserAdminController::class);

        Route::resource('conditions', ConditionAdminController::class);
        Route::resource('countries', CountryAdminController::class);

        Route::controller(ParserAdminController::class)->prefix('parsers')->name('parsers.')->group(function () {
            Route::post('auction/{auction?}', 'auction')->name('auction');

        });

        Route::resource('logs', LogAdminController::class);
        Route::resource('visits', VisitAdminController::class);

        Route::controller(JobAdminController::class)->name('jobs.')->group(function () {
            Route::get('visit_stats', 'visit_stats')->name('visit_stats');
        });


    });
});
