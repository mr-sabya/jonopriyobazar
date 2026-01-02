<?php

namespace App\Http\Controllers\Front;

use Auth;
use App\Models\Cart;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
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

	/**
     * get auth user cart items.
     *
     * @return void
     */
	public function index()
    {
        $carts = Cart::with('product')->where('user_id', Auth::user()->id)->get();
        return view('front.cart.index', compact('carts'));
    }

	/**
     * add a product in cart table.
     *
     * @return void
     */
    public function store($id)
    {
        $product = Product::where('id', $id)->first();

        $check = Cart::where('product_id', $id)->where('user_id', Auth::user()->id)->first();

        if ($check) {
            $check->quantity = $check->quantity + 1;
            $check->price = $product->sale_price * ($check->quantity);
            $check->save();
        } else {
            $cart = new Cart;

            $cart->product_id = $id;
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

    public function add(Request $request)
    {
        $product = Product::where('id', $request->product_id)->first();

        $check = Cart::where('product_id', $request->product_id)->where('user_id', Auth::user()->id)->first();

        if ($check) {
            $c_quantity = $check->quantity + $request->quantity;
            $check->quantity = $c_quantity;
            $check->price = $product->sale_price * ($c_quantity);
            $check->save();
        }else{
            $cart = new Cart;

            $cart->product_id = $product->id;
            $cart->quantity = $request->quantity;
            $cart->price = $product->sale_price * $request->quantity;
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

    public function fetchCart()
    {
        $carts = Cart::with('product')->where('user_id', Auth::user()->id)->get();
        return view('front.partials.cart', compact('carts'))->render();
    }

    public function destroy($id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::user()->id)->first();
        $cart->delete();

        return response()->json(['delete' => 'Cart item has been deleted']);
    }

    public function increment($id)
    {
        $cart = Cart::with('product')->where('id', $id)->where('user_id', Auth::user()->id)->first();
        $cart->quantity = $cart->quantity + 1;
        $cart->price = $cart->product['sale_price'] * ($cart->quantity);
        $cart->save();

        $carts = Cart::with('product')->where('user_id', Auth::user()->id)->sum('price');

        return response()->json(['carts' => $carts]);
    }

    public function decrement($id)
    {
        $cart = Cart::with('product')->where('id', $id)->where('user_id', Auth::user()->id)->first();
        $cart->quantity = $cart->quantity - 1;
        $cart->price = $cart->product['sale_price'] * ($cart->quantity);
        $cart->save();

        $carts = Cart::with('product')->where('user_id', Auth::user()->id)->sum('price');

        return response()->json(['carts' => $carts]);
    }


}
