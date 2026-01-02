<?php

namespace App\Http\Controllers\Admin;

use File;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
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
    	$setting = Setting::find(intval(1));
    	return view('backend.setting.index', compact('setting'));
    }

    public function update(Request $request)
    {
    	$setting = Setting::find(intval(1));

    	$setting->website_name = $request->website_name;
    	$setting->tagline = $request->tagline;

    	if ($request->hasFile('logo')) {
            $image_path = public_path().'/upload/images/'.$setting->logo;
            if(File::exists($image_path)){
                File::delete($image_path);
            }

            $file = $request->file('logo');
            $extension = $file->getClientOriginalName();
            $filename = time().'-logo-'.$extension;
            $file->move('upload/images/', $filename);
            $setting->logo = $filename;
        }

        if ($request->hasFile('footer_logo')) {
            $image_path = public_path().'/upload/images/'.$setting->footer_logo;
            if(File::exists($image_path)){
                File::delete($image_path);
            }

            $file = $request->file('footer_logo');
            $extension = $file->getClientOriginalName();
            $filename = time().'-footer_logo-'.$extension;
            $file->move('upload/images/', $filename);
            $setting->footer_logo = $filename;
        }

        if ($request->hasFile('invoice_logo')) {
            $image_path = public_path().'/upload/images/'.$setting->invoice_logo;
            if(File::exists($image_path)){
                File::delete($image_path);
            }

            $file = $request->file('invoice_logo');
            $extension = $file->getClientOriginalName();
            $filename = time().'-invoice_logo-'.$extension;
            $file->move('upload/images/', $filename);
            $setting->invoice_logo = $filename;
        }

        if ($request->hasFile('favicon')) {
            $image_path = public_path().'/upload/images/'.$setting->favicon;
            if(File::exists($image_path)){
                File::delete($image_path);
            }

            $file = $request->file('favicon');
            $extension = $file->getClientOriginalName();
            $filename = time().'-favicon-'.$extension;
            $file->move('upload/images/', $filename);
            $setting->favicon = $filename;
        }

        $setting->refer_percentage = $request->refer_percentage;
        $setting->min_refer = $request->min_refer;
        $setting->dev_percentage = $request->dev_percentage;
        $setting->marketing_percentage = $request->marketing_percentage;
        $setting->copyright = $request->copyright;
        $setting->meta_desc = $request->meta_desc;
        $setting->tags = $request->tags;
        $setting->terms = $request->terms;
        $setting->privacy = $request->privacy;
        $setting->refund = $request->refund;
        $setting->refer = $request->refer;
        $setting->about_1 = $request->about_1;
        $setting->about_2 = $request->about_2;


        if ($request->hasFile('og_image')) {
            $image_path = public_path().'/upload/images/'.$setting->og_image;
            if(File::exists($image_path)){
                File::delete($image_path);
            }

            $file = $request->file('og_image');
            $extension = $file->getClientOriginalName();
            $filename = time().'-og_image-'.$extension;
            $file->move('upload/images/', $filename);
            $setting->og_image = $filename;
        }

        $setting->save();

        return redirect()->route('admin.setting.index')->with('success', 'Setting has been updated successfully');


    }
}
