<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;

class UserRequestMiddleware
{

    public function handle($request, Closure $next)
    {


        return $next($request);
    }

}
