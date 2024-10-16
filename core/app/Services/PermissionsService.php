<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

/**
 * This class checks whether authenticated user has permissions 
 * to visit a certain page or perform other actions like delete, view
 * documents etc
 */
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
            return redirect()->route('webmaster.calendar.view')->with('note','You have no permission to access the previous page!');
        }
    }
}
