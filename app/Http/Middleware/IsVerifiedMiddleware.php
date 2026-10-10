<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsVerifiedMiddleware
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
        if(auth()->user()->email_verified_at == null)
        {
            return redirect()->route('user.home')->with('error', trans('trans.please_confirm_your_email'));
        }
        return $next($request);
    }
}
