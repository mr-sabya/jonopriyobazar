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
		if (request()->ajax()) {
			return datatables()->of(User::where('is_wallet', 1)->latest()->get())

			->addColumn('active_package', function ($user) {
				if($user->wallet_package_id == null){
					return "No Package Used";
				}else{
					return $user->activePackage['amount'].'-'.$user->activePackage['validate'].' Days';
				}
			})

			->addColumn('expire_on', function ($user) {
				if($user->wallet_package_id == null){
					return "No Package Used";
				}else{
					$packge = $user->userPackages->where('status', 1)->first();
					$date = Carbon::now();
					if($date > $packge->valid_to){
						return date('d-m-Y', strtotime($packge->valid_to)).'<br><span style="color:red">Expired<span>';
					}else{

						return date('d-m-Y', strtotime($packge->valid_to));
					}
				}
			})

			->addColumn('total_purchase', function ($user) {
				if($user->wallet_package_id == null){
					return "No Package Used";
				}else{
					return $user->walletPurchase->sum('amount').'৳';
				}
			})
			->addColumn('total_pay', function ($user) {
				if($user->wallet_package_id == null){
					return "No Package Used";
				}else{
					return $user->walletPay->sum('amount').'৳';
				}
			})

			->addColumn('total_due', function ($user) {
				if($user->wallet_package_id == null){
					return "No Package Used";
				}else{
					return $user->walletPurchase->sum('amount') - $user->walletPay->sum('amount').'৳';
				}
			})

			->addColumn('action', function ($user) {
				$button = '<a href="'.route('admin.walletuser.show', $user->id).'" class="show btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-eye"></i></a>';

				return $button;
			})
			->rawColumns(['active_package', 'expire_on', 'total_purchase', 'total_pay', 'total_due', 'action'])
			->addIndexColumn()
			->make(true);

		}
		return view('backend.wallet.user.index');
		
	}

	public function show($id)
	{
		$user = User::findOrFail(intval($id));
		$packages = CustomerWallet::where('user_id', $user->id)->get();

		$packs = Walletpackage::all();
		return view('backend.wallet.user.show', compact('user', 'packages', 'packs'));
	}

	public function getPurachase($id)
	{
		return datatables()->of(WalletPurchase::where('user_id', $id)->latest()->get())
		->addColumn('order', function ($purchase) {
			return '#'.$purchase->order['invoice'];
		})
		->addColumn('action', function ($purchase) {
			$button = '<a href="'.route('admin.order.show', $purchase->order_id).'" class="show btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-eye"></i></a>';

			return $button;
		})
		->rawColumns(['order', 'action'])
		->addIndexColumn()
		->make(true);
	}

	public function getPay($id)
	{
		return datatables()->of(Payments::where('user_id', $id)->latest()->get())
		
		->addColumn('action', function ($payment) {
			$button = '<a href="'.route('admin.walletuser.show', $payment->id).'" class="show btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-eye"></i></a>';
			
			return $button;
		})
		->rawColumns(['action'])
		->addIndexColumn()
		->make(true);
	}
}
