<?php

namespace App\Http\Controllers\Admin;

use App\Models\CancelReason;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CancelReasonController extends Controller
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
        return view('backend.reason.index');
    }
}
