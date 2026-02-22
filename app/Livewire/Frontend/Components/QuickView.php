<?php

namespace App\Livewire\Frontend\Components;

use App\Models\Cart;
use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class QuickView extends Component
{
    public $product;
    public $quantity = 1;

    #[On('loadQuickView')]
    public function loadProduct($productId)
    {
        $this->product = Product::findOrFail($productId);
        $this->quantity = 1;

        // Trigger the Bootstrap Modal via JavaScript
        $this->dispatch('show-quickview-modal');
    }

    public function increment()
    {
        // Check stock availability before incrementing
        if ($this->quantity < $this->product->quantity) {
            $this->quantity++;
        } else {
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Maximum available stock reached.'
            ]);
        }
    }

    public function decrement()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        // 1. Check if user is logged in
        if (!Auth::check()) {
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Please login to add items to cart'
            ]);
            return;
        }

        // 2. Call the Cart Model logic (Matches your Product component)
        $result = Cart::add($this->product->id, $this->quantity);

        // 3. Handle results
        if ($result === 'out_of_stock') {
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Not enough stock available!'
            ]);
        } elseif ($result) {
            // Success logic
            $this->dispatch('hide-quickview-modal');
            $this->dispatch('cartUpdated');

            // Optional: Open the side cart automatically
            // $this->dispatch('openSideCart');

            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => 'Product added to bag!'
            ]);
        } else {
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Failed to add product to bag!'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.frontend.components.quick-view');
    }
}
