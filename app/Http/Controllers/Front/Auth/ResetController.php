<?php

namespace App\Http\Controllers\Front\Auth;

use App\SendCode;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetController extends Controller
{
	public function forgot()
	{
		return view('front.auth.forgot');
	}

	public function resetPasswordForm($phone)
	{
		$user = User::where('phone', $phone)->first();
		return view('front.auth.password', compact('user'));
	}

}
