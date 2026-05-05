<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\WalletPurchase;
use App\Models\DeliveryStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ElectricitybillController extends Controller
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
		return view('backend.electricitybill.index');
	}

	public function show($id)
	{
		$order = Order::with('items', 'customer')->findOrFail(intval($id));
		return view('backend.electricitybill.show', compact('order'));
	}
}
