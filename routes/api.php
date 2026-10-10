<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::prefix('v1')->name('api.')->group(function () {
//    Route::prefix('user/{user_id}')->where(['user_id' => '[0-9]+'])->name('api.')->middleware('auth:sanctum')->group(function () {
//        Route::controller(AuthApiController::class)->group(function () {
//            Route::post('logout', 'logout')->name('logout');
//            Route::post('confirm', 'confirm')->name('confirm');
//            Route::post('reset-password', 'reset_password')->name('reset_password');
//        });
//    });
//
//    Route::controller(AuthApiController::class)->group(function () {
//        Route::post('login', 'login')->name('api_login');
//        Route::post('register', 'register')->name('api_register');
//        Route::post('activation', 'activation')->name('api_activation');
//        Route::post('forgot-password-send', 'forgot_password_send')->name('forgot_password_send');
//        Route::post('forgot-password', 'forgot_password')->name('forgot_password');
//    });
//
//    Route::controller(IndexApiController::class)->group(function () {
//        Route::get('', 'home')->name('home');
//    });
//});


