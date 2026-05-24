<?php

namespace App\Http\Controllers\Admin;

use File;
use App\Models\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BannerController extends Controller
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
        return view('backend.banner.index');
    }
}
