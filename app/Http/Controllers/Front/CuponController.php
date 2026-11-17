<?php

namespace App\Http\Controllers\Front;

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
			if($cupon->isExpired()){
				return response()->json(['error' => 'This cupon has been expired']);
			}else{
				if($cupon->isLimitReached()){
					return response()->json(['error' => 'You can not use this cupon']);
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
