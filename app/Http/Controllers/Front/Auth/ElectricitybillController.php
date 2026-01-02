<?php

namespace App\Http\Controllers\Front\Auth;

use Auth;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\User;
use App\Models\Order;
use App\Models\ReferPurchase;
use App\Models\WalletPurchase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\OrderRequest;

class ElectricitybillController extends Controller
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
		$orders = Order::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->where('type', 'electricity')->get();
    	return view('front.profile.pages.electricity.index', compact('orders'));
	}


    public function order(Request $request)
	{

		$validator = \Validator::make($request->all(), [
			'phone' => 'required',
			'meter_no' => 'required',
			'amount' => 'required',
		]);

		if ($validator->fails())
		{
			$errors = array(
				'phone'=>$validator->errors()->first('phone'),
				'meter_no'=>$validator->errors()->first('meter_no'),
				'amount'=>$validator->errors()->first('amount'),
			);

			return response()->json([
				'errors' => $errors,
			]);
		}

		$order = new Order;

		$order->user_id = Auth::user()->id;
		$order->invoice = time().rand(11111, 99999);
		$order->type = 'electricity';
		$order->company_id = $request->company_id;
		$order->phone = $request->phone;
		$order->meter_no = $request->meter_no;
		$order->payment_option = $request->payment_option;
		$order->sub_total = $request->amount;
		$order->total = $request->amount;
		$order->grand_total = $request->amount;
		$order->save();
		
		$user = User::where('id', Auth::user()->id)->first();
		
		$grand_total = $request->amount;
		
		if($request->payment_option == 'wallet'){
			$user->wallet_balance = $user->wallet_balance - $grand_total;
			$user->save();

			
			WalletPurchase::create([
				'user_id' => $user->id,
				'date' => Carbon::today()->toDateString(),
				'order_id' => $order->id,
				'amount' => $grand_total,
			]);
		}

		if($request->payment_option == 'refer'){
			$user->ref_balance = $user->ref_balance - $grand_total;
			$user->save();

			
			ReferPurchase::create([
				'user_id' => $user->id,
				'date' => Carbon::today()->toDateString(),
				'order_id' => $order->id,
				'amount' => $grand_total,
			]);
		}

		$data = array(
			'user_id' => Auth::user()->id,
			'order_id' => $order->id,
			'name' => Auth::user()->name,
		);

		$admins = Admin::all();
		foreach ($admins as $admin) {
			$admin->notify(new OrderRequest($data));
		}

		return response()->json(['success' => 'order confirmed']);
		
	}

	public function show($id)
	{
		$order = Order::findOrFail(intval($id));
		return view('front.profile.pages.electricity.show', compact('order'))->render();
	}
}
