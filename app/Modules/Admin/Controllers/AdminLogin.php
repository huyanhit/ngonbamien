<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminLogin extends Controller
{
    public function index(){
        if(Auth::check()) Auth::logout();
        return view('auth.login');
    }
}
