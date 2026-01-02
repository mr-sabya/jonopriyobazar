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
		if (request()->ajax()) {
			return datatables()->of( CustomerWallet::where('status', 0)->latest()->get())

			->addColumn('name', function ($package) {
				return $package->user['name'];
			})
			->addColumn('phone', function ($package) {
				return $package->user['phone'];
			})
			->addColumn('date', function ($package) {
				return date('d-m-Y', strtotime($package->created_at));
			})

			->addColumn('package', function ($package) {
				return $package->package['amount'].'-'.$package->package['validate'].'days';
			})

			->addColumn('action', function ($package) {
				$button = '<a href="'.route('admin.packageapplication.show', $package->user['id']).'" class="show btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-eye"></i></a>';

				return $button;
			})
			->rawColumns(['name', 'phone', 'package', 'date', 'action'])
			->addIndexColumn()
			->make(true);
		}
		return view('backend.wallet.package.index');
	}

	public function show($id)
	{
		$user = User::findOrFail(intval($id));
		$packages = CustomerWallet::where('user_id', $user->id)->get();

		$packs = Walletpackage::all();

		return view('backend.wallet.package.show', compact('user', 'packages', 'packs'));
	}

	public function approveWallet($id)
	{
		$package = CustomerWallet::with('package')->findOrFail(intval($id));
		$packages = CustomerWallet::where('user_id', $package->user_id)->get();

		foreach ($packages as $data) {
			$data->status = 0;
			$data->save();
		}

		$date = Carbon::now();

		$package->valid_from = Carbon::now();
		$daysToAdd = $package->package['validate'];
		$package->valid_to = new Carbon(Carbon::now()->addDays($daysToAdd));
		$package->status = 1;
		//return $package;
		$package->save();

		


		$user = User::where('id', $package->user_id)->first();

		$user->wallet_balance = $package->package['amount'];
		$user->wallet_package_id = $package->package['id'];
		$user->save();

		$data = array(
			'user_id' => $user->id,
			'info' => 'Your wallet package request is Approved!',
		);

		$user->notify(new ApproveWalletPackage($data));

		return back()->with('success', 'Package is approved');
	}

	public function assign(Request $request)
	{
		$packages = CustomerWallet::where('user_id', $request->user_id)->get();

		foreach ($packages as $data) {
			$data->status = 0;
			$data->save();
		}

		//return $request->package_id;
		$package = Walletpackage::where('id', $request->package_id)->first();
		$wallet = new CustomerWallet;
		$wallet->user_id = $request->user_id;
		$wallet->package_id = $request->package_id;
		$wallet->valid_from = Carbon::now();
		$daysToAdd = $package->validate;
		$wallet->valid_to = new Carbon(Carbon::now()->addDays($daysToAdd));
		$wallet->is_apply = 1;
		$wallet->status = 1;

		$wallet->save();


		$user = User::where('id', $request->user_id)->first();

		$user->wallet_balance = $package->amount;
		$user->wallet_package_id = $package->id;
		$user->save();

		$data = array(
			'user_id' => $user->id,
			'info' => 'Your wallet package request is Approved!',
		);

		$user->notify(new ApproveWalletPackage($data));

		return redirect()->route('admin.packageapplication.show', $request->user_id)->with('success', 'Credit Wallet Package has been assigned');
	}



	public function changePackage(Request $request)
	{
		$packages = CustomerWallet::where('user_id', $request->user_id)->get();

		foreach ($packages as $data) {
			$data->status = 0;
			$data->save();
		}

		//return $request->package_id;
		$package = Walletpackage::where('id', $request->package_id)->first();
		$wallet = new CustomerWallet;
		$wallet->user_id = $request->user_id;
		$wallet->package_id = $request->package_id;
		$wallet->valid_from = Carbon::now();
		$daysToAdd = $package->validate;
		$wallet->valid_to = new Carbon(Carbon::now()->addDays($daysToAdd));
		$wallet->is_apply = 1;
		$wallet->status = 1;

		$wallet->save();


		$user = User::where('id', $request->user_id)->first();

		$user->wallet_balance = $package->amount;
		$user->wallet_package_id = $package->id;
		$user->save();

		$data = array(
			'user_id' => $user->id,
			'info' => 'Your wallet package request is Approved!',
		);

		$user->notify(new ApproveWalletPackage($data));

		return redirect()->route('admin.walletuser.show', $request->user_id)->with('success', 'Credit Wallet Package has been changed');
	}

	public function delete($id)
	{
		$package = CustomerWallet::with('package')->findOrFail(intval($id));

		if($package->status == 1){
			return back()->with('error', 'This package is already actived for the user');
		}else{
			$package->delete();
			return back()->with('success', 'Package Request has been deleted');
		}
	}
}
