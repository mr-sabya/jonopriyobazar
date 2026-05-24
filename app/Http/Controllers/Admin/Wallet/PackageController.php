<?php

namespace App\Http\Controllers\Admin\Wallet;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Walletpackage;
use App\Models\CustomerWallet;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\ApproveWallet;
use App\Notifications\ApproveWalletPackage;


class PackageController extends Controller
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
		return view('backend.wallet.package.index');
	}

	public function show($id)
	{
		$user = User::findOrFail(intval($id));
		return view('backend.wallet.package.show', compact('user'));
	}
}
