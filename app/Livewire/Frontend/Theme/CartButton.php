<?php

namespace App\Livewire\Frontend\Theme;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartButton extends Component
{
    // Listens for the event dispatched from Product or Sidecart components
    protected $listeners = ['cartUpdated' => '$refresh'];

    public function render()
    {
        $totalItems = 0;
        $totalPrice = 0;

        if (Auth::check()) {
            $cartData = Cart::where('user_id', Auth::id())->get();
            $totalItems = $cartData->sum('quantity');
            $totalPrice = $cartData->sum(function($item) {
                return $item->quantity * $item->price;
            });
        }

        return view('livewire.frontend.theme.cart-button', [
            'totalItems' => $totalItems,
            'totalPrice' => $totalPrice
        ]);
    }
}