<?php

namespace App\Http\Controllers\Front;

use Auth;
use App\Models\User;
use App\Models\Withdraw;
use App\Models\RefPercentage;
use App\Models\ReferPurchase;
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
    	return view('front.refer.index', compact('refers'));
    }

    public function balance()
    {
        $balances = RefPercentage::where('user_id', Auth::user()->id)->get();
    	$purchases = ReferPurchase::where('user_id', Auth::user()->id)->get();
        $withdraws = Withdraw::where('user_id', Auth::user()->id)->get();
    	return view('front.refer.balance', compact('balances', 'purchases', 'withdraws'));
    }
}
