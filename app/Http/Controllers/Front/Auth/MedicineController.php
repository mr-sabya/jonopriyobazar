<?php

namespace App\Http\Controllers\Front\Auth;

use Auth;
use App\Models\User;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MedicineController extends Controller
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
    	$orders = Order::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->where('type', 'medicine')->get();
    	return view('front.profile.pages.medicine.index', compact('orders'));
    }

    public function show($invoice)
    {
        $order = Order::where('invoice', $invoice)->firstOrFail();
        return view('front.profile.pages.medicine.show', compact('order'));
    }
}
