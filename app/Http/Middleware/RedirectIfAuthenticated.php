<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {

            $role = Auth::user()->role_id;

            switch ($role) {
                case 1:
                    return redirect()->route('administrator.index', Auth::user()->username);
                    break;

                case 2:
                    return redirect()->route('center.index', Auth::user()->username);
                    break;

                case 3:
                    return redirect()->route('admin.index', Auth::user()->username);
                    break;

                case 4:
                    return redirect()->route('trainer.index');
                    break;

                case 5:
                    return redirect()->route('account.index');
                    break;
            }
        }
        return $next($request);
    }
}
