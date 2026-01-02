<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
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
        $today_order = Order::whereDate('created_at', Carbon::today())->get();
        
        $month_order = Order::whereMonth('created_at', date('m'))->get();

        $orders = Order::get();

    	return view('backend.home.index', compact(
            'today_order', 
            'month_order',
            'orders',

        ));
    }
}
