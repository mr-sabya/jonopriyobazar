<?php

namespace App\Http\Controllers\Front;

use Auth;
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
    	$this->middleware('auth');
    }

    public function index()
    {
    	if (request()->ajax()) {
    		return datatables()->of(Withdraw::where('user_id', Auth::user()->id)->latest()->get())
    		->addColumn('date', function ($withdraw) {
    			return date('d-m-Y', strtotime($withdraw->created_at));
    		})
    		->addColumn('request_amount', function ($withdraw) {
    			return $withdraw->amount."৳";
    		})
    		->addColumn('data_status', function ($withdraw) {
    			if($withdraw->status == 0){
    				$data = '<span class="badge badge-warning">Pending</span>';
    			}elseif($withdraw->status == 1){
    				$data = '<span class="badge badge-success">Completed</span>';
    			}
    			return $data;
    		})

    		
    		->rawColumns(['date', 'request_amount', 'data_status'])
    		->addIndexColumn()
    		->make(true);
    	}
    }

    public function store(Request $request)
    {
    	$validator = \Validator::make($request->all(), [
    		'amount' => 'required',
    	]);

    	if ($validator->fails())
    	{
    		$errors = array(
    			'amount'=>$validator->errors()->first('amount'),
    		);

    		return response()->json([
    			'errors' => $errors,
    		]);
    	}

    	$withdraw = new Withdraw;
    	$withdraw->user_id = Auth::user()->id;
    	$withdraw->amount = $request->amount;
    	$withdraw->status = 0;
    	$withdraw->save();

    	return response()->json(['success' => 'Withdraw Request has been sent']);
    }
}
