<?php

namespace App\Http\Controllers\Front;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	public function index()
	{
		
		
		$products = Product::inRandomOrder()->where('is_stock', 1)->limit(10)->get();
		$flash_products = Product::with('categories')->whereHas(
			'categories', function($q){
				$q->where('slug', 'flash-sale');
			}
		)
		->where('is_stock', 1)
		->orderBy('id', 'DESC')->take(6)->get();
		return view('front.home.index', compact('products', 'flash_products'));
	}
}
