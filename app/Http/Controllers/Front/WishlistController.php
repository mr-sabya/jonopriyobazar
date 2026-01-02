<?php

namespace App\Http\Controllers\Front;

use Auth;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$lists = Wishlist::where('user_id', Auth::user()->id)->get();
		return view('front.wishlist.index', compact('lists'));
	}

	public function store($id)
	{
		$check = Wishlist::where('product_id', $id)->first();
		if($check){
			return response()->json(['error' => 'This Product is already exist in Wishlist']);
		}else{
			$wishlist = new Wishlist;
			$wishlist->product_id = $id;
			$wishlist->user_id = Auth::user()->id;
			$wishlist->save();

			return response()->json(['success' => 'Added in wishlist']);
		}

	}

	public function addCart($id)
	{
		$item = Wishlist::where('id', $id)->first();
		$item->delete();

		$product = Product::where('id', $item->product_id)->first();
        $check = Cart::where('product_id', $product->id)->where('user_id', Auth::user()->id)->first();

        if ($check) {
            $check->quantity = $check->quantity + 1;
            $check->price = $product->sale_price * ($check->quantity);
            $check->save();
        } else {
            $cart = new Cart;

            $cart->product_id = $product->id;
            $cart->quantity = 1;
            $cart->price = $product->sale_price;
            $cart->user_id = Auth::user()->id;
            $cart->save();
        }

        $carts = Cart::where('user_id', Auth::user()->id)->get();

        $items = $carts->sum('quantity');
        $total = $carts->sum('price');

        return response()->json([
            'success' => 'Item added to cart',
            'items' => $items,
            'total' => $total,
        ]);
	}

	public function remove($id)
	{
		$list = Wishlist::where('id', $id)->first();
		$list->delete();

		return response()->json(['success' => 'Item is removed from wishlist']);
	}
}
