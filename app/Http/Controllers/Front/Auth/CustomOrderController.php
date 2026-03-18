<?php

namespace App\Http\Controllers\Front\Auth;

use Auth;
use App\Models\User;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomOrderController extends Controller
{

    public function index()
    {
    	return view('front.profile.pages.customorder.index');
    }

    public function show($invoice)
    {
        $order = Order::where('invoice', $invoice)->firstOrFail();
        return view('front.profile.pages.customorder.show', compact('order'));
    }
}
