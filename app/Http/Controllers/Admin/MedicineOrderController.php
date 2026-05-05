<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\WalletPurchase;
use App\Models\DeliveryStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MedicineOrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct()
	{
		$this->middleware('auth:admin');
	}

	public function index()
	{
		return view('backend.medicine-order.index');
	}

	public function show($id)
	{
		$order = Order::with('items', 'customer', 'shippingAddress', 'billingAddress')->findOrFail(intval($id));
		return view('backend.medicine-order.show', compact('order'));
	}
}
