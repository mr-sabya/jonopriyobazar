<?php

namespace App\Http\Controllers\Front\Auth;

use Auth;
use App\Models\City;
use App\Models\Thana;
use App\Models\Address;
use App\Models\District;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddressController extends Controller
{


    public function index()
    {
        return view('front.profile.pages.address.index');
    }

    public function showForm()
    {
        $districts = District::orderBy('name', 'ASC')->get();
        return view('front.address.create', compact('districts'));
    }

}
