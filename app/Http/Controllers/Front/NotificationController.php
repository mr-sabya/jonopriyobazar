<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{

	public function index()
	{
		return view('front.notification.index');
	}
}
