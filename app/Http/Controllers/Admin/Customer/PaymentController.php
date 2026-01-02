<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Models\User;
use App\Models\Payments;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'date' => 'required',
            'amount' => 'required',
        ]);

        if ($validator->fails())
        {
            $errors = array(
                'date'=>$validator->errors()->first('date'),
                'amount'=>$validator->errors()->first('amount'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }

        $payment = new Payments;
        $payment->user_id = $request->user_id;
        $payment->date = $request->date;
        $payment->amount = $request->amount;
        $payment->save();

        $user = User::where('id', $request->user_id)->first();
        $user->wallet_balance = $user->wallet_balance + $request->amount;
        $user->save();

        $wallet_balance = $user->wallet_balance;
        $total_purchase = $user->walletPurchase->sum('amount');
        $total_pay = $user->walletPay->sum('amount');
        $total_due = $user->walletPurchase->sum('amount') - $user->walletPay->sum('amount');

        return response()->json([
            'success' => 'Payment successful',
            'wallet_balance' => $wallet_balance,
            'total_purchase' => $total_purchase,
            'total_pay' => $total_pay,
            'total_due' => $total_due,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
