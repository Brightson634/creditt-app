<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIfAccountLocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
         // Check if the user is authenticated using the specified guard
         if (Auth::guard('webmaster')->check()) {
            // Get the authenticated user
            $user = Auth::guard('webmaster')->user();

            // Check if the 'is_locked' field is true
            if ($user->is_locked) {
                // Log out the user
                Auth::guard('webmaster')->logout();

                // Redirect to the login page with a message
                return redirect()->route('webmaster.login')->with('status', 'Your account is locked.');
            }
        }
        return $next($request);
    }
}
