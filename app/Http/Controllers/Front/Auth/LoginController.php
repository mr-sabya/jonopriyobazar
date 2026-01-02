<?php

namespace App\Http\Controllers\Front\Auth;

use Auth;
use App\SendCode;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

	public function login(Request $request)
	{
		$validator = \Validator::make($request->all(), [
			'phone' => 'required',
			'password' => 'required|min:5',
		],
		[
			'phone.required' => 'Please Enter your phone Number',
			'password.required' => 'Please Enter Password',
			'password.min' => 'Password must be atleast 5 Characters',
		]);

		if ($validator->fails())
		{
			$errors = array(
				'phone'=>$validator->errors()->first('phone'),
				'password'=>$validator->errors()->first('password'),
			);

			return response()->json([
				'errors' => $errors,
			]);
		}

		$user = User::where('phone', $request->phone)->first();
		if($user){
			if($user->is_varified == 1){
				if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password], $request->remember)) {
            // Redirect to dashboard

					return response()->json(['success' => 'Login successfull']);
				}else{
					$errors = array(
						'phone'=>'Phone and password does not match',
					);

					return response()->json([
						'errors' => $errors,
					]);
				}
			}else{
				$code= SendCode::sendCode($request->phone);
				if($code == "error"){
					return response()->json(['code' => 'OTP send failed! Please Try Again!']);
				}else{
					$user->code = $code;
					$user->save();

				}


				return response()->json(['phone' => $request->phone]);
			}
		}else{
			return response()->json([
				'errors' => array(
					'phone' => 'This Phone number is not registered!'
				)
			]);
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
