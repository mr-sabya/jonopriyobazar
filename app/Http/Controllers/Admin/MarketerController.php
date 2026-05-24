<?php

namespace App\Http\Controllers\Admin;

use App\Models\MarketerWithdraw;
use App\Models\MarketerPercentage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketerController extends Controller
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
		return view('backend.percentage.marketer.index');
	}
}
