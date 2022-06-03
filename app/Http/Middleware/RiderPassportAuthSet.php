<?php

namespace App\Http\Middleware;

use Closure;

class RiderPassportAuthSet
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        config(['auth.guards.api.provider' => 'riders']);
        config(['auth.providers.users.model'=>'App\models\admin\DeliveryRiders']);
        return $next($request);
    }
}
