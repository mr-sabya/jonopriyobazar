<?php

namespace App\Http\Controllers\Front;


use App\Models\PowerCompany;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ElectricitybillController extends Controller
{

	public function index()
	{
		$companies = PowerCompany::orderBy('id', 'DESC')->get();
		return view('front.electricity.index', compact('companies'));
	}

}
