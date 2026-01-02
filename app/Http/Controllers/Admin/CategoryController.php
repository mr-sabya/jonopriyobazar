<?php

namespace App\Http\Controllers\Admin;

use Auth;
use File;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
        $categories = Category::with('sub')->where('p_id', 0)->get();
        return view('backend.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::with('sub')->where('p_id', 0)->get();
        return view('backend.category.create', compact('categories'));
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
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories',
            'p_id' => 'required',
            'icon' => 'nullable|image|mimes:jpeg,jpg,gif,png|max:2048',
            'image' => 'nullable|image|mimes:jpeg,jpg,gif,png|max:2048',
        ]);

        $category = new Category;
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->p_id = $request->p_id;
        $category->added_by = Auth::user()->id;

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $extension = $file->getClientOriginalName();
            $filename = time().'-icon-'.$extension;
            $file->move('upload/images/', $filename);
            $category->icon = $filename;
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalName();
            $filename = time().'-image-'.$extension;
            $file->move('upload/images/', $filename);
            $category->image = $filename;
        }

        if($request->is_home){
            $category->is_home = $request->is_home;
        }else{
            $category->is_home = 0;
        }
        

        $category->save();

        return redirect()->route('admin.category.index')->with('success', 'New category is added successfully');
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
        $category = Category::findOrFail(intval($id));
        $categories = Category::with('sub')->where('p_id', 0)->get();
        return view('backend.category.edit', compact('categories', 'category'));
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
        $category = Category::findOrFail(intval($id));

        if($category->slug == $request->slug){
            // Validation Data
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'p_id' => 'required',
                'icon' => 'nullable|image|mimes:jpeg,jpg,gif,png|max:2048',
                'image' => 'nullable|image|mimes:jpeg,jpg,gif,png|max:2048',
            ]);
        }else{
            // Validation Data
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:categories',
                'p_id' => 'required',
                'icon' => 'nullable|image|mimes:jpeg,jpg,gif,png|max:2048',
                'image' => 'nullable|image|mimes:jpeg,jpg,gif,png|max:2048',
            ]);
        }
        

        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->p_id = $request->p_id;
        $category->added_by = Auth::user()->id;

        if ($request->hasFile('icon')) {
            $image_path = public_path().'/upload/images/'.$category->icon;
            if(File::exists($image_path)){
                File::delete($image_path);
            }

            $file = $request->file('icon');
            $extension = $file->getClientOriginalName();
            $filename = time().'-icon-'.$extension;
            $file->move('upload/images/', $filename);
            $category->icon = $filename;
        }

        if ($request->hasFile('image')) {
            $image_path = public_path().'/upload/images/'.$category->image;
            if(File::exists($image_path)){
                File::delete($image_path);
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalName();
            $filename = time().'-image-'.$extension;
            $file->move('upload/images/', $filename);
            $category->image = $filename;
        }

        if($request->is_home){
            $category->is_home = $request->is_home;
        }else{
            $category->is_home = 0;
        }

        $category->save();

        return redirect()->route('admin.category.index')->with('success', 'Category has been updated successfully');
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
