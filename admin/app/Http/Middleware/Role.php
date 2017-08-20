<?php

namespace App\Http\Middleware;

use Closure;

class Role
{
    /**
     * Check role and return 403 if not
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $roles
     * @return mixed
     * @internal param $role
     */
    public function handle($request, Closure $next, $roles)
    {
        $roles = explode('|', $roles);
        if( !is_null($request->user()) && !$request->user()->hasAnyRole($roles)){
            abort(403);
        }

        return $next($request);
    }
}
