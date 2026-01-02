<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Models\User;
use App\Models\UserPoint;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PointController extends Controller
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
			return datatables()->of(UserPoint::where('user_id', $id)->get())

			->addColumn('order_date', function ($point) {
				$date = date('d-m-Y', strtotime($point->date));
				return $date;
			})
			->addColumn('order', function ($point) {
				$order = '<a href="#">#'.$point->order['invoice'].'</a>';
				return $order;
			})


			->rawColumns(['order_date', 'order'])
			->addIndexColumn()
			->make(true);
		}
		$user = User::where('id', $id)->first();
		return view('backend.customer.point.index', compact('user'));
	}
}
