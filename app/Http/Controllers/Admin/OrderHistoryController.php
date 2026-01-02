<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\UserPoint;
use App\Models\OrderHistory;
use App\Models\ReferPurchase;
use App\Models\DeliveryStatus;
use App\Models\WalletPurchase;
use App\Models\RefPercentage;
use App\Models\MarketerPercentage;
use App\Models\DeveloperPercentage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderHistoryController extends Controller
{
	public function index($id)
	{
		if (request()->ajax()) {
			return datatables()->of(OrderHistory::where('order_id', $id)->get())
			->addColumn('status', function ($history) {
				
				return $history->status['name'];
			})
			
			->rawColumns(['status'])
			->addIndexColumn()
			->make(true);
		}
	}

	public function store(Request $request)
	{
		
        $order = Order::where('id', $request->order_id)->first();

        $history = new OrderHistory;
        $history->order_id = $order->id;
        $history->date_time = Carbon::now();
        $history->status_id = $request->status_id;
        $history->save();

        $status = DeliveryStatus::where('id', $request->status_id)->first();
        $user = User::where('id', $order->user_id)->first();

        if($status->slug == 'received'){
        	$order->status = 1;
        	$order->save();
        }elseif($status->slug == 'packed'){
        	$order->status = 2;
        	$order->save();
        }elseif($status->slug == 'delivered'){
        	$order->status = 3;
        	$order->save();
        }elseif($status->slug == 'canceled'){
        	$order->status = 4;
        	$order->save();

            if($order->payment_option == 'wallet'){
                $purchase = WalletPurchase::where('order_id', $order->id)->first();
                if( $purchase){
                    $user->wallet_balance = $user->wallet_balance + $purchase->amount;
                    $user->save();

                    $purchase->delete();
                }
            }

            if($order->payment_option == 'refer'){
                $purchase = ReferPurchase::where('order_id', $order->id)->first();
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
        }


        return response()->json(['success' => 'Delivery History is added successfully']);
    }
}
