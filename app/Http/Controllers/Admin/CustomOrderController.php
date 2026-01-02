<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\WalletPurchase;
use App\Models\DeliveryStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomOrderController extends Controller
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
			return datatables()->of(Order::where('type', 'custom')->latest()->get())
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
			
			->addColumn('time', function ($order) {
				return $order->shippingAddress['city']['name'].'<br>'.$order->created_at->diffForHumans();
			})
			->addColumn('action', function ($order) {
				$button = '<a href="'.route('admin.customorder.show', $order->id).'" class="show btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-eye"></i></a>';
				
				return $button;
			})
			->rawColumns(['order_status', 'time', 'name', 'phone', 'payment_method', 'action'])
			->addIndexColumn()
			->make(true);
		}
		return view('backend.customorder.index');
	}

	public function show($id)
	{
		$order = Order::with('items', 'customer', 'shippingAddress', 'billingAddress')->findOrFail(intval($id));
		$statuses = DeliveryStatus::orderBy('id', 'ASC')->get();
		return view('backend.customorder.show', compact('order', 'statuses'));
	}

	public function update(Request $request)
	{
		$order = Order::where('id', $request->order_id)->first();
		$user = User::where('id', $order->user_id)->first();

		if($order->payment_option == 'wallet'){
			if($user->wallet_balance < $request->grand_total){
				return response()->json(['error' => "Sorry user's Ceadit Wallet balance is low"]);
			}
		}

		$order->sub_total = $request->total;
		$order->total = $request->total;
		$order->grand_total = $request->grand_total;
		$order->save();

		if($order->payment_option == 'wallet'){
			
			$user->wallet_balance = $user->wallet_balance - $request->grand_total;
			$user->save();
			
			$check = WalletPurchase::where('order_id', $order->id)->first();
			
			if(!$check){
			    WalletPurchase::create([
				    'user_id' => $user->id,
				    'date' => Carbon::today()->toDateString(),
				    'order_id' => $order->id,
			    	'amount' => $grand_total,
		    	]);
			}

		}

		return response()->json(['success' => 'Order has been updated']);
	}

	public function changePayment(Request $request)
	{
		$order = Order::where('id', $request->order_id)->first();
		$order->payment_option = $request->payment_option;
		$order->save();

		return response()->json(['success' => 'Payment Option has been changed']);
	}
}
