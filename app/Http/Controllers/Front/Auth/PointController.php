<?php

namespace App\Http\Controllers\Front\Auth;

use App\Models\User;
use App\Models\Prize;
use App\Models\UserPoint;
use App\Models\UserPrize;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
{

    public function index()
    {
    	$points = UserPoint::where('user_id', Auth::user()->id)->get();
    	$prizes = Prize::orderBy('id', 'ASC')->get();
        $user_prizes = UserPrize::where('user_id', Auth::user()->id)->get();
    	return view('front.point.index', compact('points', 'prizes', 'user_prizes'));
    }

    public function apply($id)
    {
        $prize = Prize::find(intval($id));

        $user_prize = new UserPrize;
        $user_prize->user_id = Auth::user()->id;
        $user_prize->prize_id = $prize->id;
        $user_prize->save();

        $user = User::where('id', Auth::user()->id)->first();
        $user->point = $user->point - $prize->point;

        $user->save();

        return redirect()->route('user.point.index')->with('success', 'Thank you for apply. Jonopriyobazar will contact you soon!!');
    }
}
