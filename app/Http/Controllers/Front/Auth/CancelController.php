<?php

namespace App\Http\Controllers\Front\Auth;

use Auth;
use App\Models\Admin;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CancelController extends Controller
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

	public function product()
	{
		$orders = Order::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->where('type', 'product')->where('status', 4)->get();
    	return view('front.profile.pages.cancel.product', compact('orders'));
	}

	public function custom()
	{
		$orders = Order::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->where('type', 'custom')->where('status', 4)->get();
    	return view('front.profile.pages.cancel.custom', compact('orders'));
	}

	public function medicine()
	{
		$orders = Order::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->where('type', 'medicine')->where('status', 4)->get();
    	return view('front.profile.pages.cancel.medicine', compact('orders'));
	}

	public function electricity()
	{
		$orders = Order::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->where('type', 'electricity')->where('status', 4)->get();
    	return view('front.profile.pages.cancel.electricity', compact('orders'));
	}
}
