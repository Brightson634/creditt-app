<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class PermissionsService
{
    /**
     * Handles user permission access to different pages of the application
     *
     * @param string $permission
     * @param string $message
     * @return void
     */
    public static function check(string $permission, $message="Unauthorized  access to page!")
    {
        if (!Auth::guard('webmaster')->user()->can($permission)) {
            // // Handle if the request is DELETE or AJAX
            // if (request()->isMethod('delete') || request()->ajax()) {
            //     return response()->json([
            //         'status' => 'error',
            //         'message' => $message
            //     ], 403); // HTTP 403 Forbidden
            // }
            
            // // For non-DELETE and non-AJAX requests, perform redirect
            // $notify[] = ['error', $message];
            // session()->flash('notify', $notify);
            // dd('Hi');
            // return redirect()->back()->send();
            $page_title = 'Common Calendar';
            return view('webmaster.profile.calendar',compact('page_title'));
        }
    }
}
