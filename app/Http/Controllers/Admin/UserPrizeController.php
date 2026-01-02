<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserPrize;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserPrizeController extends Controller
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
    	$userprizes = UserPrize::orderBy('id', 'DESC')->get();
    	return view('backend.userprize.index', compact('userprizes'));
    }

    public function update($id)
    {
    	$userprize = UserPrize::findOrFail(intval($id));
    	$userprize->status = 1;
    	$userprize->save();

    	return redirect()->route('admin.userprize.index')->with('success', 'Prize has been given to user');
    }
}
