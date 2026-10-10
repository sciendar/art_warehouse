<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('seed',function (){
    Artisan::call('db:seed');
    return 'ok';
});

Route::get('mysql',function (){
    Artisan::call('migrate');
    return 'ok';
});

Route::get('clear',function (){
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
//    Artisan::call('optimize');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return 'cleared';
});

Route::get('start_storage',function (){
    Artisan::call('storage:link');
    return 'ok';
});
