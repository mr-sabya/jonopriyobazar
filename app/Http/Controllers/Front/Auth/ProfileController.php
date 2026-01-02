<?php

namespace App\Http\Controllers\Front\Auth;

use Auth;
use File;
use App\Models\District;
use App\Models\Thana;
use App\Models\Address;
use App\Models\AddressCategory;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct()
	{
		$this->middleware('auth');
	}


    /**
     * Show user profile.
     *
     * @return void
     */
    public function index()
    {
    	$shipping_address = Address::where('is_shipping', 1)->where('user_id', Auth::user()->id)->first();
    	$billing_address = Address::where('is_billing', 1)->where('user_id', Auth::user()->id)->first();
    	return view('front.profile.index', compact('shipping_address', 'billing_address'));
    }

    

    public function voucher()
    {
    	return view('front.profile.pages.voucher');
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateImage(Request $request)
    {
    	$user = User::where('id', $request->user_id)->first();

    	$validator = \Validator::make($request->all(), [
    		'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg',
    	]);

    	if ($validator->fails())
    	{
    		$errors = array(
    			'image'=>$validator->errors()->first('image'),
    		);

    		return response()->json([
    			'errors' => $errors,
    		]);
    	}

    	if ($request->hasfile('image')) {

    		$image_path = public_path() . '/upload/profile_pic/' . $user->image;

    		if (File::exists($image_path)) {
    			File::delete($image_path);
    		}

    		if ($request->hasfile('image')) {

    			$file = $request->file('image');
    			$extension = $file->getClientOriginalName();
    			$filename = time() . '-' . $extension;
    			$file->move('upload/profile_pic/', $filename);
    			$user->image = $filename;
    		}
    	}
    	$user->save();

    	return response()->json(['success' => 'Successfully updated profile picture']);

    }

    public function updateInfo(Request $request)
    {
    	$user = User::where('id', $request->user_id)->first();

    	if($user->username == $request->username){
    		$validator = \Validator::make($request->all(), [
    			'name' => 'required|string|max:255',
    			'username' => 'required|string|max:255',
    		]);
    	}else{
    		$validator = \Validator::make($request->all(), [
    			'name' => 'required|string|max:255',
    			'username' => 'required|string|max:255|unique:users',
    		]);
    	}
    	

    	if ($validator->fails())
    	{
    		$errors = array(
    			'name'=>$validator->errors()->first('name'),
    			'username'=>$validator->errors()->first('username'),
    		);

    		return response()->json([
    			'errors' => $errors,
    		]);
    	}

    	$user->name = $request->name;
    	$user->username = $request->username;
    	$user->save();

    	return response()->json(['success' => 'Your info has been changed!']);
    }



    public function phoneUpdate(Request $request, $id)
    {
    	$user = User::findOrFail(intval($id));

    	if ($user->phone == $request->phone) {
    		$validate = $this->validate($request, array(
    			'phone' => 'required|regex:/(01)[0-9]{9}/|min:11',
    		));
    	} else {
    		$validate = $this->validate($request, array(
    			'phone' => 'required|regex:/(01)[0-9]{9}/|min:11|unique:users',
    		));
    	}

    	$user->phone = $request->phone;

        //  return $request;
    	$user->save();
    	return redirect()->route('user.index');

    }

    public function updatePassword(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();


        $validator = \Validator::make($request->all(), [
            'c_password' => 'required|min:5',
            'password' => 'required|min:5',
            'confirm_password' => 'required|min:5',
        ]);
        
        

        if ($validator->fails())
        {
            $errors = array(
                'c_password'=>$validator->errors()->first('c_password'),
                'password'=>$validator->errors()->first('password'),
                'confirm_password'=>$validator->errors()->first('confirm_password'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }

        if(Hash::check($request->c_password, $user->password)){

            if($request->password == $request->confirm_password){

                $user->password = Hash::make($request->password);
                $user->save();

                return response()->json(['success' => 'Your password has been updated successfully']);

            }else{
                return response()->json([
                    'errors' => array(
                        'confirm_password' => 'Confirm password does not match!',
                    ),
                ]);
            }

        }else{
            return response()->json([
                'errors' => array(
                    'c_password' => 'Current password does not match!',
                ),
            ]);
        }
    }


}
