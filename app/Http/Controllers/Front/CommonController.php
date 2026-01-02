<?php

namespace App\Http\Controllers\Front;

use App\Models\City;
use App\Models\Thana;
use App\Models\District;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function getThana($id)
    {
    	$thanas = Thana::orderBy('name', 'ASC')->where('district_id', $id)->get();

    	$thana = '';

    	foreach ($thanas as $data) {
    		$thana .= '<option value="'.$data->id.'">'.$data->name.'</option>';
    	}

    	return response()->json(['thana' => $thana]);
    }

    public function getCity($id)
    {
    	$cities = City::orderBy('name', 'ASC')->where('thana_id', $id)->get();

    	$city = '';

    	foreach ($cities as $data) {
    		$city .= '<option value="'.$data->id.'">'.$data->name.'</option>';
    	}

    	return response()->json(['city' => $city]);
    }
}
