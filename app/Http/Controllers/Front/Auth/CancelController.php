<?php

namespace App\Http\Controllers\Front\Auth;

use Auth;
use App\Models\Admin;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CancelController extends Controller
{
	public function index()
	{
		return view('front.profile.pages.cancel.index');
	}

	public function cancelOrder($invoice)
    {
        $order = Order::where('invoice', $invoice)->firstOrFail();
        return view('front.profile.pages.cancel.create', compact('order'));
    }
	
	public function cancelSuccess()
    {
        return view('front.profile.pages.cancel.success');
    }
}
