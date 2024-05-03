<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
   protected function redirectTo($request)
    { 
        if (! $request->expectsJson()) {
            if (\Request::is('webmaster') || \Request::is('webmaster/*')){
                return route('webmaster.login');
            }
            else if(\Request::is('member') || \Request::is('member/*')){
                return route('member.login');
            }
            else{
                return route('/');
            } 
        }
   }
}
