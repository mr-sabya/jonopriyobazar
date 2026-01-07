<?php

namespace App\Livewire\Frontend\Components;

use App\Models\Cart;
use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\On;

class QuickView extends Component
{
    public $product;
    public $quantity = 1;

    // Listen for the "loadQuickView" event from any other component
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
        $this->quantity++;
    }
    public function decrement()
    {
        if ($this->quantity > 1) $this->quantity--;
    }

    public function addToCart()
    {
        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'qty' => $this->quantity,
            'price' => $this->product->sale_price,
            'weight' => 0,
            'options' => ['image' => $this->product->image]
        ]);

        $this->dispatch('hide-quickview-modal');
        $this->dispatch('cartUpdated');
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Product added to bag!']);
    }

    public function render()
    {
        return view('livewire.frontend.components.quick-view');
    }
}
