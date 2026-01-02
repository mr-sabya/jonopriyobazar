<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Models\Orderitem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
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
        if (request()->ajax()) {
            return datatables()->of(User::latest()->get())

            ->addColumn('verify_status', function ($user) {
                if($user->is_varified == 1){
                    $status = '<span class="badge badge-success">Verified</span>';
                }else{
                    $status = '<span class="badge badge-warning">Unverified</span>';
                }
                return $status;
            })

            ->addColumn('customer_status', function ($user) {
                if($user->status == 1){
                    $status = '<span class="badge badge-success">Active</span>';
                }elseif ($customer->status == 2) {
                    $status = '<span class="badge badge-warning">Hold</span>';
                }else{
                    $status = '<span class="badge badge-danger">Deactive</span>';
                }
                return $status;
            })

            ->addColumn('refers', function ($user) {
                return $user->refers->count();
            })

            ->addColumn('create_time', function ($user) {
                return date('d-F, Y', strtotime($user->created_at)).'<br>'.date('h:m a', strtotime($user->created_at));
            })


            ->addColumn('action', function ($user) {
                $button = '<a  name="show" href="'.route('admin.customer.show', $user->id).'" id="'.$user->id.'" class="show btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-eye"></i></a>';
                return $button;
            })
            ->rawColumns(['verify_status', 'customer_status', 'refers', 'create_time', 'action',])
            ->addIndexColumn()
            ->make(true);
        }
        return view('backend.customer.index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail(intval($id));
        $addresses = Address::where('user_id', $user->id)->get();
        $orders = Order::where('user_id', $user->id)->where('status', 3)->get();
        $refer_count = User::where('referral_id', $id)->count();
        return view('backend.customer.show', compact('user', 'addresses', 'orders', 'refer_count'));
    }


    public function fetchOrder($id)
    {
        if (request()->ajax()) {
            return datatables()->of(Order::where('user_id', $id)->latest()->get())
            ->addColumn('order_status', function ($order) {
                if($order->status == 0){
                    $status = '<span class="badge badge-warning">Pending</span>';
                }elseif($order->status == 1){
                    $status = '<span class="badge badge-primary">Received</span>';
                }elseif($order->status == 2){
                    $status = '<span class="badge badge-info">Packed</span>';
                }elseif($order->status == 3){
                    $status = '<span class="badge badge-success">Delivered</span>';
                }elseif($order->status == 4){
                    $status = '<span class="badge badge-danger">Canceled</span>';
                }
                return $status;
            })

            ->addColumn('name', function ($order) {

                return $order->customer['name'];
            })
            ->addColumn('phone', function ($order) {

                return $order->customer['phone'];
            })
            
            ->addColumn('time', function ($order) {
                if($order->shipping_address_id != ''){
                    $address = $order->shippingAddress['city']['name'].'<br>';
                }else{
                    $address = '';
                }
                return $address.$order->created_at->diffForHumans();
            })
            ->addColumn('payment_method', function ($order) {
                if($order->payment_option == 'cash'){
                    $data = "Cash On Delievery";
                }elseif($order->payment_option == 'wallet'){
                    $data = "Credit Wallet";
                }elseif ($order->payment_option == 'refer') {
                    $data = "Refer Wallet";
                }

                return $data;
            })
            ->addColumn('action', function ($order) {

                if($order->type == 'product'){
                    $button = '<a href="'.route('admin.order.show', $order->id).'" class="show btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-eye"></i></a>';
                }elseif ($order->type == 'custom') {
                    $button = '<a href="'.route('admin.customorder.show', $order->id).'" class="show btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-eye"></i></a>';
                }elseif ($order->type == 'electricity') {
                    $button = '<a href="'.route('admin.electricity.show', $order->id).'" class="show btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-eye"></i></a>';
                }elseif ($order->type == 'medicine') {
                    $button = '<a href="'.route('admin.medicine.show', $order->id).'" class="show btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-eye"></i></a>';
                }
                
                
                return $button;
            })
            ->rawColumns(['order_status', 'time', 'name', 'phone', 'payment_method', 'action'])
            ->addIndexColumn()
            ->make(true);
        }
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

    public function referStatus($id)
    {
        $customer = User::findOrFail(intval($id));

        if($customer->is_percentage == 1){
            $customer->is_percentage = 0;
            $message = "Customer refer percentage has been deactived!";
        }elseif ($customer->is_percentage == 0) {
            $customer->is_percentage = 1;
            $message = "Customer refer percentage has been actived!";
        }

        $customer->save();

        return back()->with('success', $message);
    }
}
