<?php

namespace App\Http\Controllers\Front\Auth;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\District;
use App\Models\Thana;
use App\Models\Address;
use App\Models\AddressCategory;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

	/**
	 * Show user profile.
	 *
	 * @return void
	 */
	public function index()
	{
		return view('front.profile.index');
	}

	public function dashboard()
	{
		return view('front.profile.pages.dashboard.index');
	}

	public function voucher()
	{
		return view('front.profile.pages.voucher');
	}
}
