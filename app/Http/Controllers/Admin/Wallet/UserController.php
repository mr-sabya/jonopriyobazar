<?php

namespace App\Http\Controllers\Admin\Wallet;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Payments;
use App\Models\Walletpackage;
use App\Models\CustomerWallet;
use App\Models\WalletPurchase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
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
		
		return view('backend.wallet.user.index');
		
	}

	public function show($id)
	{
		$user = User::findOrFail(intval($id));
		return view('backend.wallet.user.show', compact('user',));
    }
}
