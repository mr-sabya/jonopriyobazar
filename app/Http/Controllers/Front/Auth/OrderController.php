<?php

namespace App\Http\Controllers\Front\Auth;

use Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\UserPoint;
use App\Models\CancelReason;
use App\Models\ReferPurchase;
use App\Models\RefPercentage;
use App\Models\WalletPurchase;
use App\Models\MarketerPercentage;
use App\Models\DeveloperPercentage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
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
    	$orders = Order::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->where('type', 'product')->get();
    	return view('front.profile.pages.order.index', compact('orders'));
    }

    public function show($invoice)
    {
        $order = Order::where('invoice', $invoice)->firstOrFail();
        return view('front.profile.pages.order.show', compact('order'));
    }

    public function cancelOrder($invoice)
    {
        $order =  Order::where('invoice', $invoice)->firstOrFail();
        $reasons = CancelReason::all();
        return view('front.profile.pages.order.cancel', compact('order', 'reasons'));
    }

    public function cancelOrderSubmit(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'reason_id' => 'required',
            'is_agree_cancel' => 'required'
        ]);

        if ($validator->fails())
        {
            $errors = array(
                'reason_id'=>$validator->errors()->first('reason_id'),
                'is_agree_cancel'=>$validator->errors()->first('is_agree_cancel'),
            );

            return response()->json([
                'errors' => $errors,
            ]);
        }

        $order = Order::where('id', $request->order_id)->firstOrFail();

        $order->reason_id = $request->reason_id;
        $order->remark = $request->remark;
        $order->is_agree_cancel = $request->is_agree_cancel;
        $order->status = 4;

        $order->save();

        $user = User::where('id', Auth::user()->id)->first();

        if($order->payment_option == 'wallet'){
            $purchase = WalletPurchase::where('order_id', $request->order_id)->first();
            if( $purchase){
                $user->wallet_balance = $user->wallet_balance + $purchase->amount;
                $user->save();

                $purchase->delete();
            }
        }

        if($order->payment_option == 'refer'){
            $purchase = ReferPurchase::where('order_id', $request->order_id)->first();
            if( $purchase){
                $user->ref_balance = $user->ref_balance + $purchase->amount;
                $user->save();

                $purchase->delete();
            }
        }


        // remove refer percentage
        $refer = RefPercentage::where('order_id', $order->id)->first();

        if($refer){
            

            $leader = User::where('id', $refer->user_id)->first();
            $leader->ref_balance = $leader->ref_balance - $refer->amount;
            $leader->save();

            $refer->delete();
        }

        $point = UserPoint::where('order_id', $order->id)->first();

        if($point){
            $user->point = $user->point - $point->point;
            $user->save();
            $point->delete();
        }

        $developer = DeveloperPercentage::where('order_id', $order->id)->first();
        if($developer){
            $developer->delete();
        }

        $marketer = MarketerPercentage::where('order_id', $order->id)->first();
        if($marketer){
            $marketer->delete();
        }

        return response()->json([
            'route' => route('profile.order.cencel.success'),
        ]);
    }

    public function cancelSuccess()
    {
        return view('front.profile.pages.order.cancelsuccess');
    }
}
