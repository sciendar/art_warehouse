<?php

use App\Http\Middleware\IsApproveMiddleware;
use App\Http\Middleware\IsUserMiddleware;
use App\Http\Middleware\IsVerifiedMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\FixVisitsMiddleware;
use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Middleware\LocaleMiddleware;
use App\Http\Middleware\UserRequestMiddleware;
use Illuminate\Auth\Middleware\Authenticate;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth'         => Authenticate::class,
            'locale'       => LocaleMiddleware::class,
            'is_admin'     => IsAdminMiddleware::class,
            'is_user'      => IsUserMiddleware::class,
            'is_verified'  => IsVerifiedMiddleware::class,
            'is_approved'  => IsApproveMiddleware::class,
            'fix_visits'   => FixVisitsMiddleware::class,
            'user_request' => UserRequestMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
