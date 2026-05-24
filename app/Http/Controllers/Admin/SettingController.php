<?php

namespace App\Http\Controllers\Admin;

use File;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
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
    	return view('backend.setting.index');
    }

}
