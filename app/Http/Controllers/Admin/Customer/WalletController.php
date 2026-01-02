<?php

namespace App\Http\Controllers\Admin\Customer;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Walletpackage;
use App\Models\CustomerWallet;
use App\Models\WalletPurchase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\ApproveWallet;
use App\Notifications\ApproveWalletPackage;

class WalletController extends Controller
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


	public function approve($id)
	{
		$user = User::findOrFail(intval($id));

		$user->is_wallet = 1;
		$user->wallet_request = 0;
		$user->save();

		$data = array(
			'user_id' => $user->id,
			'info' => 'Your wallet is Approved!',
		);

		$user->notify(new ApproveWallet($data));

		return response()->json(['success' => 'This user is approved for wallet']);
		
	}

	public function hold($id)
	{
		$user = User::findOrFail(intval($id));
		$user->is_hold = 1;
		$user->save();

		return back()->with('success', 'Wallet  has been hold!');
	}

	public function reactive($id)
	{
		$user = User::findOrFail(intval($id));
		$user->is_hold = 0;
		$user->save();

		return back()->with('success', 'Wallet  has been Re-Actived!');
	}

	public function extendPackage(Request $request)
	{
		//return $request;
		$package = CustomerWallet::where('package_id', $request->package_id)->first();
		$package->valid_to = $request->valid_to;
		$package->save();

		$user = User::where('id', $package->user_id)->first();
		$user->is_expired = 0;
		$user->save();

		return back()->with('success', 'User credit wallet date has been extended');
	}


	
}
