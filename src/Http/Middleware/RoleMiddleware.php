<?php

namespace Despark\Cms\Http\Middleware;

use Auth;
use Closure;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $role
     * @param $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null, $permission = null)
    {
        if (Auth::guest()) {
            return redirect('/admin/login');
        }

        if ($role && ! $request->user()->hasRole($role)) {
            throw new NotFoundHttpException;
        }

        if ($permission && ! $request->user()->can($permission)) {
            throw new NotFoundHttpException;
        }

        return $next($request);
    }
}
