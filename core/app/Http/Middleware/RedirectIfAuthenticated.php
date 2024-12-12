<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

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
            // return redirect(route('member.dashboard'));
            $member = Member::find(Auth::guard($guard)->id());
            return redirect(route('member.membercalendar.view', ['id' => $member->member_no]));
        }
        // if (Auth::check()) {
        //     return redirect(route('user.dashboard'));
        // }

        return $next($request);
    }
}
