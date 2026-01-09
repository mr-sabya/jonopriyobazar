<?php

namespace App\Http\Controllers\Front\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
	public function showForm()
	{
		if(Auth::user()){
			return redirect()->route('home');
		}else{
			return view('front.auth.login');
		}
	}
                    

	public function verifyForm()
	{
		return view('front.auth.verify');
	}
}
