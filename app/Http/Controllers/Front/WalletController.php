<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

class WalletController extends Controller
{


    public function index()
    {
        return view('front.wallet.index');
    }


    public function show()
    {
        return view('front.wallet.show');
    }
}
