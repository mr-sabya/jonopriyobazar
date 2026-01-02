<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReferController extends Controller
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
    
    public function index($id)
    {
    	if (request()->ajax()) {
            return datatables()->of(User::where('referral_id', $id)->get())

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

           ->addColumn('orders', function ($user) {
                return $user->orders->count();
            })

           
            ->rawColumns(['verify_status', 'customer_status', 'orders'])
            ->addIndexColumn()
            ->make(true);
        }
        
    }
}
