<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Branch;
use App\Models\Tenants;
use App\Utility\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SetUserMiddleware
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
      if (Auth::guard('webmaster')->check()) {
            $user = Auth::guard('webmaster')->user();
            
            $request->attributes->set('user', $user);
            $request->attributes->set('branch_id', $user->branch_id);
            $branch = Branch::find($user->branch_id);

            if (!is_null($branch) && !is_null($branch->default_currency)) {
                $request->attributes->set('default_branch_curr', $branch->default_currency);
            }
            $request->attributes->set('business_id', $user->tenant_id);
            $tenant = Tenants::find($user->tenant_id);
            if ($tenant) {
                Session::put('tenant', $tenant);
            }
        } else {
            // Redirect unauthenticated users to the webmaster login
            return redirect()->route('login');
        }

        return $next($request);
        return $next($request);
    }
}
