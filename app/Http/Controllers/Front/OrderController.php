<?php

namespace App\Http\Controllers\Front;

use Auth;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Cupon;
use App\Models\Setting;
use App\Models\Orderitem;
use App\Models\Product;
use App\Models\RefPercentage;
use App\Models\ReferPurchase;
use App\Models\MarketerPercentage;
use App\Models\DeveloperPercentage;
use App\Models\WalletPurchase;
use App\Models\UserPoint;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\OrderRequest;

class OrderController extends Controller
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

	public function order(Request $request)
	{
		$setting = Setting::where('id', 1)->first();
		$items = Cart::where('user_id', Auth::user()->id)->get();
		$user = User::where('id', Auth::user()->id)->first();


		$order = new Order;

		$order->user_id = Auth::user()->id;
		$order->invoice = time().rand(11111, 99999);
		$order->shipping_address_id = $request->shipping_address_id;
		$order->billing_address_id = $request->billing_address_id;
		$order->type = 'product';
		$order->payment_option = $request->payment_option;

		// cupon
		$off = 0;
		if($request->cupon_id){
			$cupon = Cupon::where('id', $request->cupon_id)->first();
			$off = $off + $cupon->amount;
			$order->cupon_id = $request->cupon_id;
		}

		// calculation
		if($request->payment_option == 'wallet'){
			$sub_total = 0;
			foreach ($items as $item) {
				$sub_price = $item->quantity * $item->product['actual_price'];
				$sub_total = $sub_total + $sub_price;
			}
		}else{
			$sub_total = $items->sum('price');
		}

		$total = $sub_total - $off;
		$grand_total = $total + $request->delivery_charge;

		// order total
		$order->sub_total = $sub_total;
		$order->total = $total;
		$order->grand_total = $grand_total;

		$order->save();


		if($request->payment_option == 'wallet'){
			$user->wallet_balance = $user->wallet_balance - $grand_total;
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



		// leader percentage
		$leader = User::where('id', Auth::user()->referral_id)->first();

		if($leader){
			if($leader->is_percentage == 1){
				$leader_percentage = 0;

				foreach ($items as $item) {

					if($item->product['is_percentage'] == 1){
						$peroduct_percentage = ($setting->refer_percentage * $item->product['sale_price'])/100;
						$leader_percentage = $leader_percentage + $peroduct_percentage;
					}
				}

				$leader->ref_balance = $leader->ref_balance + $leader_percentage;
				$leader->save();

				if($leader_percentage > 0){
					RefPercentage::create([
						'user_id' => $leader->id,
						'date' => Carbon::today()->toDateString(),
						'order_id' => $order->id,
						'amount' => $leader_percentage,
					]);
				}
			}
		}
		

		// percentage
		$developer_percentage = 0;
		$marketer_percentage = 0;

		foreach ($items as $item) {

			if($item->product['is_percentage'] == 1){
				// developer
				$dev_get = ($setting->dev_percentage * $item->product['sale_price'])/100;
				$developer_percentage = $developer_percentage + $dev_get;

				//marketer
				$marketer_get = ($setting->marketing_percentage * $item->product['sale_price'])/100;
				$marketer_percentage = $marketer_percentage + $marketer_get;
			}
		}

		// developer percentage
		if($developer_percentage > 0){
			DeveloperPercentage::create([
				'date' => Carbon::today()->toDateString(),
				'order_id' => $order->id,
				'amount' => $developer_percentage,
			]);
		}

		
		// marketer percentage
		if($marketer_percentage > 0){
			MarketerPercentage::create([
				'date' => Carbon::today()->toDateString(),
				'order_id' => $order->id,
				'amount' => $marketer_percentage,
			]);
		}

		// point
		$point = 0;
		foreach ($items as $item) {
			$p_point = $item->quantity * $item->product['point'];
			$point = $point + $p_point;
		}

		if($point > 0){
			UserPoint::create([
				'user_id' => $user->id,
				'date' => Carbon::today()->toDateString(),
				'order_id' => $order->id,
				'point' => $point,
			]);

			$user->point = $user->point + $point;
			$user->save();
		}
		

		// add order item
		foreach ($items as $item) {
			$orderitem = new Orderitem;
			$orderitem->order_id = $order->id;
			$orderitem->product_id = $item->product_id;
			$orderitem->quantity = $item->quantity;

			if($request->payment_option == 'wallet'){
				$orderitem->price = $item->quantity * $item->product['actual_price'];
			}else{
				$orderitem->price = $item->price;
			}

			$orderitem->save();

			$item->delete();
		}



		// notification
		$data = array(
			'user_id' => Auth::user()->id,
			'order_id' => $order->id,
			'name' => Auth::user()->name,
		);

		$admins = Admin::all();
		foreach ($admins as $admin) {
			$admin->notify(new OrderRequest($data));
		}


		return redirect()->route('order.complete')->with('success', 'Thank you for your order');
	}

	public function complete()
	{
		return view('front.order.complete');
	}


	
}
