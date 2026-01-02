<?php

namespace App\Http\Controllers\Admin;

use File;
use Auth;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
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
        if(request()->ajax())
        {
            return datatables()->of(Product::with('categories')->orderBy('id', 'DESC')->get())
            ->addColumn('productimage', function($data){
                $url = "/upload/images/".$data->image;
                return '<img src="'.$url.'">';
            })
            ->addColumn('categories', function($data){
                $product_category = '';
                foreach ($data->categories as $category) {
                    $product_category .= '<span class="badge badge-primary">'.$category->name.'</span>';
                }
                return $product_category;
            })
            ->addColumn('action', function($data){
                $button = '<a href="/control/products/'.$data->id.'/edit" name="edit" id="'.$data->id.'" class="btn btn-table waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-edit"></i></a>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-table waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></button>';
                return $button;
            })
            ->rawColumns(['productimage', 'categories', 'action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('backend.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::with('sub')->where('p_id', 0)->get();
        return view('backend.product.create', compact('categories'));
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
            'slug' => 'required|string|max:255|unique:products',
            'category' => 'required',
            'quantity' => 'required|max:20',
            'sale_price' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,jpg,gif,png|max:2048',
        ]);

        $product = new Product;

        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->quantity = $request->quantity;
        $product->sale_price = $request->sale_price;
        $product->actual_price = $request->actual_price;
        $product->off = $request->off;

        if($request->is_percentage == 1){
            $product->is_percentage = $request->is_percentage;
        }

        $product->point = $request->point;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalName();
            $filename = time().'-image-'.$extension;
            $file->move('upload/images/', $filename);
            $product->image = $filename;
        }
        
        if($request->is_stock == 1){
            $product->is_stock = 1;
        }else{
            $product->is_stock = 0;
        }

        $product->description = $request->description;
        $product->added_by = Auth::user()->id;

        $product->save();

        $product->categories()->sync($request->category);

        return redirect()->route('admin.products.index');
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
        $product = Product::with('categories')->findOrFail(intval($id));
        $categories = Category::with('sub')->where('p_id', 0)->get();
        return view('backend.product.edit', compact('categories', 'product'));
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
        $product = Product::findOrFail(intval($id));
        if($product->slug == $request->slug){
            // Validation Data
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'category' => 'required',
                'quantity' => 'required|max:20',
                'sale_price' => 'required|integer',
                'image' => 'nullable|image|mimes:jpeg,jpg,gif,png|max:2048',
            ]);
        }else{
        // Validation Data
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:products',
                'category' => 'required',
                'quantity' => 'required|max:20',
                'sale_price' => 'required|integer',
                'image' => 'nullable|image|mimes:jpeg,jpg,gif,png|max:2048',
            ]);
        }

        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->quantity = $request->quantity;
        $product->sale_price = $request->sale_price;
        $product->actual_price = $request->actual_price;
        $product->off = $request->off;

        if($request->is_percentage == 1){
            $product->is_percentage = 1;
        }else{
            $product->is_percentage = 0;
        }
        
        $product->point = $request->point;

        if ($request->hasFile('image')) {
            $image_path = public_path().'/upload/images/'.$product->image;
            if(File::exists($image_path)){
                File::delete($image_path);
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalName();
            $filename = time().'-image-'.$extension;
            $file->move('upload/images/', $filename);
            $product->image = $filename;
        }

        if($request->is_stock == 1){
            $product->is_stock = 1;
        }else{
            $product->is_stock = 0;
        }

        $product->description = $request->description;
        $product->added_by = Auth::user()->id;

        $product->save();

        if (isset($request->category)) {
            $product->categories()->sync($request->category);
        } else {
            $product->categories()->sync(array());
        }

        return redirect()->route('admin.products.edit', $product->id)->with('success', 'This product has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail(intval($id));

        $image_path = public_path().'/upload/images/'.$product->image;
        if(File::exists($image_path)){
            File::delete($image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product has been deleted');
    }
}
