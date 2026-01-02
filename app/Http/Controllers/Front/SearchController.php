<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
    	$products = Product::where('name', 'LIKE', '%' . $request->search . '%')->get();
    	return view('front.shop.search', compact('products'));
    }
}
