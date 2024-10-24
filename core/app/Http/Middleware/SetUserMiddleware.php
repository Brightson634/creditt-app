<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Branch;
use App\Utility\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::check()) {
            $user = Auth::user();
            $request->attributes->set('user', $user);
            $request->attributes->set('branch_id', $user->branch_id);
            $branch = Branch::find($user->branch_id);

            if (!is_null($branch->default_currency)) {
                $request->attributes->set('default_branch_curr', $branch->default_currency);
            }
            $branchName = Branch::find($user->branch_id)->name;
            $business = Business::where('name', $branchName)->where('owner_id', $user->branch_id)->first();
            if ($business) {
                $request->attributes->set('business_id', $business->id);
            }
        }
        return $next($request);
    }
}
