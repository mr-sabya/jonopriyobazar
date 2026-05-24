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
		$user = User::where('id', $id)->first();
		return view('backend.customer.referbalance.index', compact('user'));
	}
}
