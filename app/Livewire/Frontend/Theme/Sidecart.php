<?php

namespace App\Livewire\Frontend\Theme;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidecart extends Component
{
    // This property keeps the cart open during Livewire re-renders
    public $isCartOpen = false;

    protected $listeners = [
        'cartUpdated' => '$refresh',
        'openSideCart' => 'openCart'
    ];

    public function openCart()
    {
        $this->isCartOpen = true;
    }

    public function closeCart()
    {
        $this->isCartOpen = false;
    }

    public function increment($id)
    {
        $cart = Cart::where('user_id', Auth::id())->find($id);
        if ($cart && $cart->product->quantity > $cart->quantity) {
            $cart->increment('quantity');
            $this->dispatch('cartUpdated');
        } else {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'Limit reached']);
        }
    }

    public function decrement($id)
    {
        $cart = Cart::where('user_id', Auth::id())->find($id);
        if ($cart && $cart->quantity > 1) {
            $cart->decrement('quantity');
            $this->dispatch('cartUpdated');
        } else {
            $this->removeItem($id);
        }
    }

    public function removeItem($id)
    {
        Cart::where('user_id', Auth::id())->where('id', $id)->delete();
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        $carts = Auth::check()
            ? Cart::with('product')->where('user_id', Auth::id())->get()
            : collect();

        $subtotal = $carts->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        return view('livewire.frontend.theme.sidecart', [
            'carts' => $carts,
            'subtotal' => $subtotal
        ]);
    }
}
