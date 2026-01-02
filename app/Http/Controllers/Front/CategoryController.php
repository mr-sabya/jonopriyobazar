<?php

namespace App\Http\Controllers\Front;

use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
	public function index()
	{
		$categories = Category::where('p_id', 0)->get();
		$category = '';
		return view('front.category.index', compact('categories', 'category'));
	}

	public function sub($slug)
	{
		$category = Category::where('slug', $slug)->first();
		$categories = Category::where('p_id', $category->id)->get();
		if($categories->count()>0){
			return view('front.category.index', compact('categories', 'category'));
		}else{
			$products = Product::with('categories')->whereHas(
				'categories', function($q) use ($category){
					$q->where('id', $category->id);
				}
			)
			->where('is_stock', 1)
			->orderBy('id', 'DESC')->paginate(30);
			return view('front.product.index', compact('products', 'category'));
		}
	}

	public function fetch(Request $request)
	{
		if($request->ajax()){
			$category = Category::where('id', $request->category_id)->first();

			$products = Product::with('categories')->whereHas(
				'categories', function($q) use ($category){
					$q->where('id', $category->id);
				}
			)
			->where('is_stock', 1)
			->orderBy('id', 'DESC')->paginate(30);
			return view('front.product.partials.list', compact('products'))->render();
		}
		
	}
}
