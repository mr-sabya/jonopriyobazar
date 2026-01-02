<?php

namespace App\Http\Controllers\Front\Auth;

use Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReferController extends Controller
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

    public function index()
    {
    	$refers = User::where('referral_id', Auth::user()->id)->get();
    	return view('front.profile.pages.refer.index', compact('refers'));
    }
}
