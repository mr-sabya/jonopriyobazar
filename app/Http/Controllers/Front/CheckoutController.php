<?php

namespace App\Http\Controllers\Front;

use Auth;
use App\Models\Cart;
use App\Models\Address;
use App\Models\District;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{


    public function index()
    {
        return view('front.checkout.index');
    }

    // order success
    public function orderSuccess($order_id)
    {
        return view('front.checkout.order-success', compact('order_id'));
    }
}
