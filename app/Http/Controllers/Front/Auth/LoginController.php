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

	public function verify(Request $request)
	{
		if($request->code_1 == '' || $request->code_2 == '' || $request->code_3 == '' || $request->code_4 == ''){
			return response()->json(['code' => 'Please Enter your OTP']);
		}else{
			$user = User::where('phone', $request->phone)->first();
			$code = $request->code_1.$request->code_2.$request->code_3.$request->code_4;
			if($user->code == $code){
				$user->code = null;
				$user->is_varified = 1;
				$user->save();

				Auth::login($user);
				return response()->json(['success' => 'Login successfull']);

			}else{
				return response()->json(['code' => 'OTP code does not match! Please try again.']);
			}
		}
	}

	public function logout()
	{
		Auth::guard('web')->logout();
		return redirect()->route('login');
	}
}
