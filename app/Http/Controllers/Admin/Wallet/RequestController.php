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
    	if (request()->ajax()) {
    		return datatables()->of(User::where('wallet_request', 1)->latest()->get())
    		->addColumn('date', function ($user) {
    			return date('d-m-Y', strtotime($user->request_date));
    		})

    		->addColumn('action', function ($user) {
    			$button = '<a href="'.route('admin.walletrequest.show', $user->id).'" class="show btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-eye"></i></a>';

    			return $button;
    		})
    		->rawColumns(['date', 'action'])
    		->addIndexColumn()
    		->make(true);
    	}
    	return view('backend.wallet.request.index');
    }

    public function show($id)
    {
    	$user = User::findOrFail(intval($id));
    	return view('backend.wallet.request.show', compact('user'));
    }
}
