<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsApproveMiddleware
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
        if(auth()->user()->is_approved == true)         {
            return $next($request);
        }
        return redirect()->route('user.home')->with('error', trans('trans.wait_for_your_account_to_be_confirmed'));
    }
}
