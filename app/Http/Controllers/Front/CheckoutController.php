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
    	$addresses = Address::where('user_id', Auth::user()->id)->get();

        if($addresses->count()>0){
            
            $carts = Cart::with('product')->where('user_id', Auth::user()->id)->get();
            $districts = District::orderBy('name', 'ASC')->get();
            $shipping_address = Address::where('user_id', Auth::user()->id)->where('is_shipping', 1)->first();
            $billing_address = Address::where('user_id', Auth::user()->id)->where('is_billing', 1)->first();
            return view('front.checkout.index', compact('addresses', 'carts', 'districts', 'shipping_address', 'billing_address'));
        }else{
            return redirect()->route('address.showform');
        }

    }
}
