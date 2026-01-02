<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function quick($id)
    {
    	$product = Product::with('categories')->where('id', $id)->firstOrFail();
    	return view('front.product.quick', compact('product'));
    }

    public function index()
    {
        $category = '';
    	$products = Product::with('categories')->orderBy('name', 'ASC')->where('is_stock', 1)->paginate(30);
    	return view('front.shop.index', compact('products', 'category'));
    }

    public function fetch(Request $request)
    {
    	if($request->ajax()){

			$products = Product::with('categories')->orderBy('name', 'ASC')->where('is_stock', 1)->paginate(30);
			return view('front.product.partials.list', compact('products'))->render();
		}
		
    }
}
