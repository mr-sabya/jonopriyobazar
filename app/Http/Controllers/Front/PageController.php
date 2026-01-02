<?php

namespace App\Http\Controllers\Front;

use App\Models\Faq;
use App\Models\Team;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $setting = Setting::where('id', 1)->first();
        $teams = Team::orderBy('id', 'ASC')->get();
    	return view('front.pages.about', compact('teams', 'setting'));
    }

    public function faq()
    {
        $faqs = Faq::orderBy('id', 'ASC')->get();
    	return view('front.pages.faq', compact('faqs'));
    }


    public function refer()
    {
        $setting = Setting::where('id', 1)->first('refer');
    	return view('front.pages.refer', compact('setting'));
    }
    
    public function terms()
    {
        $setting = Setting::where('id', 1)->first('terms');
        return view('front.pages.terms', compact('setting'));
    }

    public function privacy()
    {
        $setting = Setting::where('id', 1)->first('privacy');
    	return view('front.pages.privacy', compact('setting'));
    }
}
