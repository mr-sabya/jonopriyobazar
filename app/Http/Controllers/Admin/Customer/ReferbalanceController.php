<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Models\User;
use App\Models\RefPercentage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReferbalanceController extends Controller
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

	public function index($id)
	{
		if (request()->ajax()) {
			return datatables()->of(RefPercentage::where('user_id', $id)->get())

			->addColumn('order_date', function ($refer) {
				$date = date('d-m-Y', strtotime($refer->date));
				return $date;
			})
			->addColumn('order', function ($refer) {
				$order = '<a href="#">#'.$refer->order['invoice'].'</a>';
				return $order;
			})


			->rawColumns(['order_date', 'order'])
			->addIndexColumn()
			->make(true);
		}
		$user = User::where('id', $id)->first();
		return view('backend.customer.referbalance.index', compact('user'));
	}
}
