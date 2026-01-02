<?php

namespace App\Http\Controllers\Admin\Report;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaleReportController extends Controller
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
		return view('backend.report.sale');
	}

	public function search(Request $request)
	{
		if (request()->ajax()) {

			$from = $request->from;
			$to = $request->to;
			$type = $request->type;
			$payment_option = $request->payment_option;


			if($type == 'all' && $payment_option == 'all'){
				$orders = Order::whereBetween('created_at', [$from, $to])->where('status', 3)->latest()->get();
			}elseif($type == 'all'){
				$orders = Order::whereBetween('created_at', [$from, $to])->where('payment_option', $request->payment_option)->where('status', 3)->latest()->get();
			}elseif($payment_option == 'all'){
				$orders = Order::whereBetween('created_at', [$from, $to])->where('type', $request->type)->where('status', 3)->latest()->get();
			}else{
				$orders = Order::whereBetween('created_at', [$from, $to])->where('payment_option', $request->payment_option)->where('type', $request->type)->where('status', 3)->latest()->get();
			}

			return datatables()->of($orders)
			->addColumn('name', function ($order) {
				return $order->customer['name'];
			})
			->addColumn('phone', function ($order) {
				return $order->customer['phone'];
			})

			->addColumn('type', function ($order) {
				if($order->type == 'product'){
					return "Product Order";
				}elseif($order->type == 'custom'){
					return "Custom Order";
				}elseif ($order->type == 'medicine') {
					return "Medicine Order";
				}elseif ($order->type == 'electricity') {
					return "Electricity Bill";
				}
			})
			->addColumn('payment_method', function ($order) {
				if($order->payment_option == 'cash'){
					$data = "Cash On Delievery";
				}elseif($order->payment_option == 'wallet'){
					$data = "Credit Wallet";
				}elseif ($order->payment_option == 'refer') {
					$data = "Refer Wallet";
				}

				return $data;
			})
			->rawColumns(['name', 'phone', 'payment_method', 'type'])
			->addIndexColumn()
			->make(true);
			

		}
	}
}
