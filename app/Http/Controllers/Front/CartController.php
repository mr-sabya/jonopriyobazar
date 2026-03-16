<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
	/**
     * get auth user cart items.
     *
     * @return void
     */
	public function index()
    {
        $carts = Cart::with('product')->where('user_id', Auth::user()->id)->get();
        return view('front.cart.index', compact('carts'));
    }

}
