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

	public function sendCode(Request $request)
	{
		$validator = \Validator::make($request->all(), [
			'phone' => 'required',
		]);


		if ($validator->fails())
		{
			$errors = array(
				'phone'=>$validator->errors()->first('phone'),
			);

			return response()->json([
				'errors' => $errors,
			]);
		}

		$user = User::where('phone', $request->phone)->first();

		if($user){

			$code= SendCode::sendCode($request->phone);
			if($code == "error"){
				return response()->json(['error' => 'OTP send failed! Please Try Again!']);
			}else{
				$user->code = $code;
				$user->save();

				return response()->json(['success' => route('user.verify', $user->phone)]);
			}

		}else{
			return response()->json(['error' => 'Wrong phone number! Please enter valid phone number']);
		}
	}

	public function verifyForm($phone)
	{
		$user = User::where('phone', $phone)->first();
		return view('front.auth.resetverify', compact('user'));
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
				$user->save();

				return response()->json(['success' => route('reset.password.form', $user->phone)]);

			}else{
				return response()->json(['code' => 'OTP code does not match! Please try again.']);
			}
		}
	}

	public function resetPasswordForm($phone)
	{
		$user = User::where('phone', $phone)->first();
		return view('front.auth.password', compact('user'));
	}

	public function reset(Request $request)
	{
		$validator = \Validator::make($request->all(), [
            'password' => 'required|min:5',
        ]);

        if ($validator->fails())
        {
            $errors = array(
                'password'=>$validator->errors()->first('password'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }

        $user = User::where('phone', $request->phone)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['success' => route('login')]);
	}
}
