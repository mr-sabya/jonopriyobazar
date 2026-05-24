<?php

namespace App\Http\Controllers\Admin;

use App\Models\DeveloperWithdraw;
use App\Models\DeveloperPercentage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeveloperController extends Controller
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
		return view('backend.percentage.developer.index');
	}
}
