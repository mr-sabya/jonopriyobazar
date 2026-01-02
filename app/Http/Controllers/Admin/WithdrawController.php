<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Withdraw;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WithdrawController extends Controller
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
    	$withdraws = Withdraw::orderBy('id', 'DESC')->get();
    	return view('backend.withdraw.index', compact('withdraws'));
    }

    public function update($id)
    {
    	$withdraw = Withdraw::findOrFail(intval($id));

    	$withdraw->status = 1;
    	$withdraw->save();

    	$user = User::where('id', $withdraw->user_id)->first();
    	$user->ref_balance = $user->ref_balance - $withdraw->amount;
    	$user->save();

    	return redirect()->route('admin.withdraw.index')->with('success', 'User withdraw has been completed');
    }
}
