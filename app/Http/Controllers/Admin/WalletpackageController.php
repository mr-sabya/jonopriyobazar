<?php

namespace App\Http\Controllers\Admin;

use App\Models\Walletpackage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WalletpackageController extends Controller
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
        return view('backend.walletpackage.index');
    }
}
