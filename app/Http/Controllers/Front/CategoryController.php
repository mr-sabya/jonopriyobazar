<?php

namespace App\Http\Controllers\Front;

use App\Models\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
	// For "All Categories" page
	public function index()
	{
		$category = null;
		return view('front.category.index', compact('category'));
	}

	// For specific category or sub-category page
	public function sub($slug)
	{
		$category = Category::where('slug', $slug)->firstOrFail();
		// We pass the whole category object to the view for the title and meta tags
		return view('front.category.index', compact('category'));
	}
}
