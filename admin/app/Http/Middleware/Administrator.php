<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Administrator
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response(trans('backpack::base.unauthorized'), 401);
            }
            else {
                return redirect()->guest(config('backpack.base.route_prefix', 'admin').'/login');
            }
        }

        else{
            if(!Auth::user()->can('view admin')){
                return response(trans('backpack::base.unauthorized'), 401);
                //return redirect('/');
            }
        }

        return $next($request);
    }
}
