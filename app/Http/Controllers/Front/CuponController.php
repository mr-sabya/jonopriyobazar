<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Models\Cupon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CuponController extends Controller
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

	public function apply(Request $request)
	{
		$cupon = Cupon::where('code', $request->code)->first();

		if($cupon){
			if($cupon->expire_date < Carbon::now()){
				return response()->json(['error' => 'This cupon has been expired']);
			}else{
				if($cupon->limit != 0){
					if($cupon->limit > $request->total){
						return response()->json(['error' => 'You can not use this cupon']);
					}else{
						return response()->json(['cupon' => $cupon]);
					}
				}else{
					return response()->json(['cupon' => $cupon]);
				}
			}
		}else{
			return response()->json(['error' => 'Sorry this cupon is not available']);
		}

	}

	public function remove($id)
	{
		$cupon = Cupon::findOrFail(intval($id));
		return response()->json(['cupon' => $cupon]);
	}
}
