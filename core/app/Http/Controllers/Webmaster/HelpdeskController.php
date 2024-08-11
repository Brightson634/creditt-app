<?php

namespace App\Http\Controllers\Webmaster;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HelpdeskController extends Controller
{
    //
    public function __construct()
    {
      $this->middleware('auth:webmaster');
    }
    public function index()
    {
        $page_title = 'Help Desk';
        return view('webmaster.helpdesk.index',compact('page_title'));
    }
}
