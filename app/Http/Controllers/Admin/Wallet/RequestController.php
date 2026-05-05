<?php

namespace App\Http\Controllers\Admin\Wallet;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestController extends Controller
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
    	return view('backend.wallet.request.index');
    }
}
