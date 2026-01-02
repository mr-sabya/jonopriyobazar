<?php

namespace App\Http\Controllers\Front;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$notifications = Auth::user()->notifications()->paginate(20);
		return view('front.notification.index', compact('notifications'));
	}

	public function fetch(Request $request)
	{
		if($request->ajax()){
			$notifications = Auth::user()->notifications()->paginate(20);
			return view('front.notification.partials.list', compact('notifications'))->render();
		}
	}

	public function show($id)
	{
		$notification = Auth::user()->notifications()->where('id', $id)->first();

		if($notification){
			$notification->markAsRead();
			if($notification->data['role'] == 'wallet'){
				return redirect()->route('user.wallet');
			}
			elseif($notification->data['role'] == 'walletpackage'){
				return redirect()->route('user.wallet');
			}
		}
	}

	public function markRead()
	{
		Auth::user()->unreadNotifications->markAsRead();
		return response()->json(['success' => 'All notifications are successfully mark as read']);
	}
}
