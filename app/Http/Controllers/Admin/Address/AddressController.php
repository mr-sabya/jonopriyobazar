<?php

namespace App\Http\Controllers\Admin\Address;

use App\Http\Controllers\Controller;

class AddressController extends Controller
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
    public function district()
    {
        return view('backend.address.district');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function thana()
    {
        return view('backend.address.thana');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function city()
    {
        return view('backend.address.city');
    }
}