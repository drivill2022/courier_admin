<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAdmin
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = 'admin')
	{
	    if (!Auth::guard($guard)->check()) {
	        return redirect('admin/login');
	    }
	    if (Auth::guard($guard)->user()->status!='Active') {
	    	Auth::guard($guard)->logout();
	    	$request->session()->flush();
	    	$request->session()->regenerate();
	        return redirect('admin/login')->with('flash_error','Your account has been blocked. Please contact with Drivill Administrator.');
	    }

	    return $next($request);
	}
}