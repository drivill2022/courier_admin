<?php

namespace App\Http\Middleware;

use Closure;
use App\models\admin\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class RolesAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $actionName =Route::getCurrentRoute()->uri();
        if(strrpos($actionName, 'admin/permissions')!==false  && $request->ip()==''){
            return redirect('/')->with('flash_error', 'Sorry! You are not authorised to access this service');
        }  
        if($request->method()=='PATCH'){
            return $next($request);
        }
        if(session('expire') < Date('Y-m-d H:i:s') || is_null(session('permissions'))){   
            $role = Role::with('permissions')->findOrFail(auth()->guard('admin')->user()->role_id);        
            $permissions = $role->permissions;
            $min=env('PERMISSION_UPDATE_REFRESH',5);
            session(['permissions'=>$permissions,'expire'=>date('Y-m-d H:i:s',strtotime('+'.$min.' minutes'))]);
        }else{
            $permissions = session('permissions');
        }
        $default_permission=['admin/dashboard','admin/logout','admin/profile','admin/edit-profile'];
        $routeName =$request->path(); 
        foreach ($permissions as $permission) {
            if($actionName == $permission->slug || $permission->slug == '*' || $routeName == $permission->slug || in_array($actionName, $default_permission)) {   
                return $next($request);
            }           
        }
        return redirect()->route('admin.dashboard')->with('flash_error', 'Sorry! You are not authorised to access this service');
    }
}
