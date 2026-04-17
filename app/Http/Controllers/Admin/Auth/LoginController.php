<?php

namespace App\Http\Controllers\Admin\Auth;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    
    public function showLoginForm()
    {
        return view('backend.auth.login');
    }
}
