<?php

namespace App\Http\Controllers\Admin;

use File;
use App\Models\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BannerController extends Controller
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
        $banners = Banner::orderBy('id', 'DESC')->get();
        return view('backend.banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation Data
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,jpg,gif,png|max:2048',
        ]);

        $banner = new Banner;
        $banner->title = $request->title;
        $banner->link = $request->link;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalName();
            $filename = time().'-banner-'.$extension;
            $file->move('upload/images/', $filename);
            $banner->image = $filename;
        }

        $banner->save();

        return redirect()->route('admin.banner.index')->with('success', 'New banner is added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::findOrFail(intval($id));
        return view('backend.banner.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validation Data
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,gif,png|max:2048',
        ]);

        $banner = Banner::findOrFail(intval($id));
        $banner->title = $request->title;
        $banner->link = $request->link;
        

        if ($request->hasFile('image')) {
            $image_path = '/home/jonolewi/public_html/upload/images/'.$banner->image;
            if(File::exists($image_path)){
                File::delete($image_path);
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalName();
            $filename = time().'-banner-'.$extension;
            $file->move('upload/images/', $filename);
            $banner->image = $filename;
        }

        $banner->save();

        return redirect()->route('admin.banner.index')->with('success', 'Banner has been successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
