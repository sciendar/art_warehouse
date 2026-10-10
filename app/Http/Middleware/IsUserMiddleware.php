<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user()->email_verified_at == null || in_array(null, [auth()->user()->country_id, auth()->user()->address, auth()->user()->state, auth()->user()->city, auth()->user()->zip_code]))         {
            return redirect()->route('user.home');
        }
        return $next($request);
    }
}
