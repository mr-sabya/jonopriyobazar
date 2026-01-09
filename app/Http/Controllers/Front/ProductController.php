<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
    	$products = Product::with('categories')->orderBy('name', 'ASC')->where('is_stock', 1)->paginate(30);
    	return view('front.shop.index', compact('products'));
    }

}
