<?php

namespace App\Livewire\Frontend\Components;

use App\Models\Cart;
use Livewire\Component;
use App\Models\Product as ProductModel;
use Illuminate\Support\Facades\Auth;

class Product extends Component
{
    public $product;
    public $showModal = false;
    public $quantity = 1;

    public function mount($productId)
    {
        $this->product = ProductModel::findOrFail($productId);
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->quantity = 1;
    }

    public function increment()
    {
        if ($this->quantity < $this->product->quantity) {
            $this->quantity++;
        } else {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'Maximum available stock reached.']);
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
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'Please login to add items to cart']);
            return;
        }

        // 2. Call the Cart Model logic
        $result = Cart::add($this->product->id, $this->quantity);

        // 3. Handle results with Session Flash
        if ($result === 'out_of_stock') {
            session()->flash('error', 'Not enough stock available!');
        } elseif ($result) {
            $this->closeModal();

            // Still dispatching this so your Navbar/Header can refresh the count
            $this->dispatch('cartUpdated');
            $this->dispatch('swal', ['icon' => 'success', 'title' => 'Product added to bag!']);
        } else {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'Failed to add product to bag!']);
        }
    }

    public function render()
    {
        return view('livewire.frontend.components.product');
    }
}
