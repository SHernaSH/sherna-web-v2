<?php

namespace App\Http\Middleware;

use App\Models\Roles\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RolesAuth
{
    /**
     * Handle an incoming request and determine if the user has permission to use this action
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // get user role permissions
        if (auth()->user()) {
            $role = Role::findOrFail(auth()->user()->role_id);
        } else {
//            $role = Role::where('name', 'guest')->first();
            $role = Role::where('name', 'super_admin')->first();
        }
        $permissions = $role->permissions;
        // get requested action
        $actionName = $request->route()->getActionname();
        // check if requested action is in permissions list
        foreach ($permissions as $permission) {
            if (Str::contains($actionName, '@')) {
                $req_action = $permission->controller . '@' . $permission->method;
            } else {
                $req_action = $permission->method;
            }
            if ($actionName == $req_action) {
                // authorized request
                return $next($request);
            }
        }
        // none authorized request
        return abort(403, 'Unauthorized Action');
    }
}
