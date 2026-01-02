<?php

namespace App\Http\Controllers\Front;

use Auth;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Address;
use App\Models\District;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\OrderRequest;

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
		$shipping_address = Address::where('user_id', Auth::user()->id)->where('is_shipping', 1)->first();
		$billing_address = Address::where('user_id', Auth::user()->id)->where('is_billing', 1)->first();
		$districts = District::orderBy('name', 'ASC')->get();
		return view('front.medicine.index', compact('shipping_address', 'billing_address', 'districts'));
	}
	public function store(Request $request)
	{

		if(!$request->shipping_address_id){
			$validator = \Validator::make($request->all(), [
				'name' => 'required|string|max:255',
				'phone' => 'required',
				'street' => 'required|max:255',
				'district_id' => 'required',
				'thana_id' => 'required',
				'city_id' => 'required',
				'post_code' => 'required',
				'type' => 'required',
				'custom' => 'nullable|string',
				'image' => 'required|image|mimes:jpeg,jpg,gif,png|max:2048',
			]);

			if ($validator->fails())
			{
				$errors = array(
					'name'=>$validator->errors()->first('name'),
					'phone'=>$validator->errors()->first('phone'),
					'street'=>$validator->errors()->first('street'),
					'district_id'=>$validator->errors()->first('district_id'),
					'thana_id'=>$validator->errors()->first('thana_id'),
					'city_id'=>$validator->errors()->first('city_id'),
					'post_code'=>$validator->errors()->first('post_code'),
					'type'=>$validator->errors()->first('type'),
					'custom'=>$validator->errors()->first('custom'),
					'image'=>$validator->errors()->first('image'),
				);

				return response()->json([
					'errors' => $errors,
				]);
			}
		}else{
			
			$validator = \Validator::make($request->all(), [
				'custom' => 'nullable',
				'image' => 'required|image|mimes:jpeg,jpg,gif,png|max:2048',
			]);

			if ($validator->fails())
			{
				$errors = array(
					
					'custom'=>$validator->errors()->first('custom'),
					'image'=>$validator->errors()->first('image'),
				);

				return response()->json([
					'errors' => $errors,
				]);
			}
		}

		if($request->name){
			$address = new Address;

			$address->user_id = Auth::user()->id;
			$address->name = $request->name;
			$address->phone = $request->phone;
			$address->street = $request->street;
			$address->district_id = $request->district_id;
			$address->thana_id = $request->thana_id;
			$address->city_id = $request->city_id;
			$address->post_code = $request->post_code;
			$address->type = $request->type;
			$address->is_shipping = 1;
			$address->is_billing = 1;

			$address->save();
		}

		$order = new Order;

		$order->user_id = Auth::user()->id;
		$order->invoice = time().rand(11111, 99999);

		if($request->shipping_address_id){
			$order->shipping_address_id = $request->shipping_address_id;
			$order->billing_address_id = $request->billing_address_id;
		}else{
			$order->shipping_address_id = $address->id;
			$order->billing_address_id = $address->id;
		}
		
		$order->type = 'medicine';
		$order->payment_option = $request->payment_option;
		$order->custom = $request->custom;

		if ($request->hasFile('image')) {
			$file = $request->file('image');
			$extension = $file->getClientOriginalName();
			$filename = time().'-medicine-order-'.$extension;
			$file->move('upload/images/', $filename);
			$order->image = $filename;
		}



		$order->save();

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

		return response()->json([
			'success' => 'Thank you for your order!',
		]);

		
	}

}
