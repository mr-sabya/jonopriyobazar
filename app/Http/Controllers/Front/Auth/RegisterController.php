<?php

namespace App\Http\Controllers\Front\Auth;

use Auth;
use App\SendCode;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showForm()
    {
        if(Auth::user()){
            return redirect()->route('home');
        }else{
            return view('front.auth.register');
        }
    }

    public function register(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:users',
            'password' => 'required|min:5',
        ]);

        if ($validator->fails())
        {
            $errors = array(
                'name'=>$validator->errors()->first('name'),
                'phone'=>$validator->errors()->first('phone'),
                'password'=>$validator->errors()->first('password'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }

        if($request->ref_code){
            $refer = User::where('affiliate_code', $request->ref_code)->first();

            if(!$refer){
                $errors = array(
                    'ref_code'=> 'Refer Code Does not match with any user!',
                );

                return response()->json([
                    'errors' => $errors,
                ]);
            }

        }

        
        $code= SendCode::sendCode($request->phone);
        if($code == "error"){
            return response()->json(['code' => 'OTP send failed! Please Try Again!']);
        }else{
            $user = new User;
            $user->name = $request->name;
            $user->username = $this->createUsername($request->name);
            $user->phone = $request->phone;
            $user->code = $code;
            $user->affiliate_code = time().mt_rand(111111, 999999);

            if($request->ref_code){
                $user->referral_id = $refer->id;
            }

            $user->password = Hash::make($request->password);
            $user->status = 1;

            $user->save();
            return response()->json(['phone' => $request->phone]);

        }
    }

    /**
     * Create a slug from title
     * @param  string $title
     * @return string $slug
     */
    protected function createUsername(string $name): string
    {

        $usernameFounds = $this->getUsernames($name);
        $counter = 0;
        $counter += $usernameFounds;

        $username = str_slug($name, $separator = "-", app()->getLocale());

        if ($counter) {
            $username = $username . '-' . $counter;
        }
        return $username;
    }

    /**
     * Find same listing with same name
     * @param  string $name
     * @return int $total
     */
    protected function getUsernames($name): int
    {
        return User::select()->where('name', 'like', $name)->count();
    }
}
