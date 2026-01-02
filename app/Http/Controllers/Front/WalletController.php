<?php

namespace App\Http\Controllers\Front;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Models\Payments;
use App\Models\Walletpackage;
use App\Models\CustomerWallet;
use App\Models\WalletPurchase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\WalletApply;
use App\Notifications\ApplyWalletPackage;

class WalletController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function index()
    {
        $user = User::with('applywallets')->where('id', Auth::user()->id)->first();

        $packages = Walletpackage::orderBy('id', 'ASC')->get();

        $active_package = CustomerWallet::where('user_id', Auth::user()->id)->where('status', 1)->first();

        // deactive wallet
        if($active_package){
            if($active_package->valid_to < Carbon::now()){
                $user->is_expired = 1;
                $user->save();
            } 
        }


        return view('front.wallet.index', compact('packages', 'active_package'));
    }

    public function store(Request $request)
    {
    	$user = User::where('id', $request->id)->firstOrFail();

    	if($user->n_id_front == null || $user->n_id_back == null){
    		$validator = \Validator::make($request->all(), [
    			'n_id_front' => 'required|image|mimes:jpeg,jpg,gif,png',
    			'n_id_back' => 'required|image|mimes:jpeg,jpg,gif,png',
    		]);

    		if ($validator->fails())
    		{
    			$errors = array(
    				'n_id_front'=>$validator->errors()->first('n_id_front'),
    				'n_id_back'=>$validator->errors()->first('n_id_back'),
    			);

    			return response()->json([
    				'errors' => $errors,
    			]);
    		}
    	}

        $user->wallet_request = 1;
        $user->request_date = Carbon::now();

        if ($request->hasFile('n_id_front')) {
            $file = $request->file('n_id_front');
            $extension = $file->getClientOriginalName();
            $filename = time().'-'.Auth::user()->name.'-nid-'.$extension;
            $file->move('upload/images/', $filename);
            $user->n_id_front = $filename;
        }

        if ($request->hasFile('n_id_back')) {
            $file = $request->file('n_id_back');
            $extension = $file->getClientOriginalName();
            $filename = time().'-'.Auth::user()->name.'-nid-'.$extension;
            $file->move('upload/images/', $filename);
            $user->n_id_back = $filename;
        }

        $user->save();

        $data = array(
            'user_id' => Auth::user()->id,
            'name' => Auth::user()->name,
        );

        $admins = Admin::all();
        foreach ($admins as $admin) {
            $admin->notify(new WalletApply($data));
        }

        return response()->json(['success' => 'Thank you for your request. We will contact you soon!']);
    }

    public function apply($id)
    {

        $package = Walletpackage::findOrFail(intval($id));

        $wallet = new CustomerWallet;
        $wallet->user_id = Auth::user()->id;
        $wallet->package_id = $package->id;
        $wallet->is_apply = 1;

        $wallet->save();

        $data = array(
            'user_id' => Auth::user()->id,
            'name' => Auth::user()->name,
            'package' => $package,
        );

        $admins = Admin::all();
        foreach ($admins as $admin) {
            $admin->notify(new ApplyWalletPackage($data));
        }

        return response()->json(['success' => 'Successfully applied for Wallet Package']);
    }


    public function show()
    {
        $purchases = WalletPurchase::where('user_id', Auth::user()->id)->get();
        $pays = Payments::where('user_id', Auth::user()->id)->get();
        $active_package = CustomerWallet::where('user_id', Auth::user()->id)->where('status', 1)->first();
        return view('front.wallet.show', compact('purchases', 'pays', 'active_package'));
    }
}
