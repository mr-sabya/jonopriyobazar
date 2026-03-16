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
    public function index()
    {
    	return view('front.profile.pages.order.index');
    }

    public function show($invoice)
    {
        $order = Order::where('invoice', $invoice)->firstOrFail();
        return view('front.profile.pages.order.show', compact('order'));
    }
}
