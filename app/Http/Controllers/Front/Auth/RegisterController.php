<?php

namespace App\Http\Controllers\Front\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
}
