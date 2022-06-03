<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class RedirectIfNotSeller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'seller')
    {
        if (!Auth::guard($guard)->check()) {
            return redirect('seller/login');
        }
        if (Auth::guard($guard)->user()->status!='Active') {
            Auth::guard($guard)->logout();
            $request->session()->flush();
            $request->session()->regenerate();
            return redirect('seller/login')->with('flash_error','Your account has been blocked. Please contact with Drivill Administrator.');
        }
        return $next($request);
    }
}
