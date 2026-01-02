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
		if (request()->ajax()) {
			return datatables()->of(Order::where('type', 'product')->latest()->get())
			->addColumn('order_status', function ($order) {
				if($order->status == 0){
					$status = '<span class="badge badge-warning">Pending</span>';
				}elseif($order->status == 1){
					$status = '<span class="badge badge-primary">Received</span>';
				}elseif($order->status == 2){
					$status = '<span class="badge badge-info">Packed</span>';
				}elseif($order->status == 3){
					$status = '<span class="badge badge-success">Delivered</span>';
				}elseif($order->status == 4){
					$status = '<span class="badge badge-danger">Canceled</span>';
				}
				return $status;
			})
			->addColumn('name', function ($order) {
				
				return $order->customer['name'];
			})
			->addColumn('phone', function ($order) {
				
				return $order->customer['phone'];
			})
			
			->addColumn('time', function ($order) {
				return $order->shippingAddress['city']['name'].'<br>'.$order->created_at->diffForHumans();
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
			->addColumn('action', function ($order) {
				$button = '<a href="'.route('admin.order.show', $order->id).'" class="show btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-eye"></i></a>';
				
				return $button;
			})
			->rawColumns(['order_status', 'time', 'name', 'phone', 'payment_method', 'action'])
			->addIndexColumn()
			->make(true);
		}
		return view('backend.order.index');
	}

	public function show($id)
	{
		$order = Order::with('items', 'customer', 'shippingAddress', 'billingAddress')->findOrFail(intval($id));
		//return $order->shippingAddress;
		$statuses = DeliveryStatus::orderBy('id', 'ASC')->get();
		return view('backend.order.show', compact('order', 'statuses'));
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
