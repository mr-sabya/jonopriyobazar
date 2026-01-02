<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\User;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
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
    
    public function show($id)
    {
    	$notification = Auth::user()->notifications()->where('id', $id)->first();

    	if($notification){
            $notification->markAsRead();
            if($notification->data['role'] == 'wallet'){
                $customer = User::findOrFail(intval($notification->data['data']['user_id']));
                return redirect()->route('admin.walletrequest.show', $customer->id);
            }
            if($notification->data['role'] == 'walletpackage'){
                $customer = User::findOrFail(intval($notification->data['data']['user_id']));
                return redirect()->route('admin.packageapplication.show', $customer->id);
            }
            if($notification->data['role'] == 'order'){
                $order = Order::findOrFail(intval($notification->data['data']['order_id']));

                if($order->type = 'product'){
                    return redirect()->route('admin.order.show', $order->id);
                }elseif ($order->type = 'custom') {
                    return redirect()->route('admin.customorder.show', $order->id);
                }elseif ($order->type = 'electricity') {
                    return redirect()->route('admin.electricity.show', $order->id);
                }elseif ($order->type = 'medicine') {
                    return redirect()->route('admin.medicine.show', $order->id);
                }
            }
        }
    }
}
