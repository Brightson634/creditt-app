<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($guard == 'webmaster' && Auth::guard($guard)->check()) {
            return redirect(route('webmaster.dashboard'));
        }
        if ($guard == 'member' && Auth::guard($guard)->check()) {
            return redirect(route('member.dashboard'));
        }
        // if (Auth::check()) {
        //     return redirect(route('user.dashboard'));
        // }
      
        return $next($request);
    }
}
