<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

class CustomOrderController extends Controller
{

	// Display a listing of the resource.
	public function index()
	{
		return view('front.custom.index');
	}
}
