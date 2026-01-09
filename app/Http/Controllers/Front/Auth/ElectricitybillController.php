<?php

namespace App\Http\Controllers\Front\Auth;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ElectricitybillController extends Controller
{


	public function index()
	{
		$orders = Order::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->where('type', 'electricity')->get();
    	return view('front.profile.pages.electricity.index', compact('orders'));
	}


	public function show($id)
	{
		$order = Order::findOrFail(intval($id));
		return view('front.profile.pages.electricity.show', compact('order'))->render();
	}
}
