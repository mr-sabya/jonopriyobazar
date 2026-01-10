<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

class ReferController extends Controller
{

    public function index()
    {
    	return view('front.refer.index');
    }

    public function balance()
    {
    	return view('front.refer.balance');
    }
}
