<?php

namespace App\Livewire\Frontend\Components;

use App\Models\Cart;
use Livewire\Component;
use App\Models\Product as ProductModel;
use Illuminate\Support\Facades\Auth;

class Product extends Component
{
    public $product;
    public $showModal = false; // Controls Modal Visibility
    public $quantity = 1;      // Local state for modal quantity

    public function mount($productId)
    {
        $this->product = ProductModel::findOrFail($productId);
    }

    // Toggle Modal
    public function openModal()
    {
        $this->showModal = true;
    }
    public function closeModal()
    {
        $this->showModal = false;
        $this->quantity = 1;
    }

    // Quantity Controls
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

        $this->closeModal();
        $this->dispatch('cartUpdated');
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Product added to bag!']);
    }

    public function render()
    {
        return view('livewire.frontend.components.product');
    }
}
