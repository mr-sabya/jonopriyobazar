<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Setting;
use App\Models\Orderitem;
use App\Models\DeliveryStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
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
		return view('backend.order.index');
	}

	public function show($id)
	{
		$order = Order::findOrFail(intval($id));
		return view('backend.order.show', compact('order'));
	}

	public function getStatus()
	{
		$statuses = DeliveryStatus::orderBy('id', 'ASC')->get();

		$status = '';

		foreach ($statuses as $data) {
			$status .= '<option value="'.$data->id.'">'.$data->name.'</option>';
		}

		return response()->json(['status' => $status]);
	}

	public function download($id)
	{
		$setting = Setting::where('id', 1)->first();

		$order = Order::with('items', 'customer', 'shippingAddress', 'billingAddress')->findOrFail(intval($id));
		$pdf = PDF::loadView('backend.order.pdf',compact('order', 'setting'));
		return $pdf->download($order->invoice.'.pdf');
	}

}
