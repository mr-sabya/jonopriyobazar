<?php

namespace App\Livewire\Frontend\Components;

use App\Models\Cart;
use App\Models\Wishlist; // Import the Wishlist model
use App\Models\Product as ProductModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Product extends Component
{
    public $product;
    public $showModal = false;
    public $isInWishlist = false; // Track state
    public $quantity = 1;

    public function mount($productId)
    {
        $this->product = ProductModel::findOrFail($productId);

        // Check initial wishlist status
        if (Auth::check()) {
            $this->isInWishlist = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $this->product->id)
                ->exists();
        }
    }

    // --- EXISTING METHODS (openModal, increment, etc.) ---

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

    /**
     * Add to Wishlist Method
     */
    public function addToWishlist()
    {
        // 1. Check if user is logged in
        if (!Auth::check()) {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'Please login to add items to wishlist']);
            return;
        }

        // 2. Check if product is already in wishlist
        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $this->product->id)
            ->exists();

        if ($exists) {
            $this->dispatch('swal', ['icon' => 'info', 'title' => 'Product is already in your wishlist!']);
            return;
        }

        // 3. Create Wishlist record
        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $this->product->id
        ]);

        // 4. Dispatch events for UI feedback
        $this->dispatch('wishlistUpdated'); // Useful if you have a counter in the header
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Added to wishlist!']);
    }

    public function addToCart()
    {
        if (!Auth::check()) {
            return $this->redirect(route('login'), navigate: true);
        }

        $result = Cart::add($this->product->id, $this->quantity);

        if ($result === 'out_of_stock') {
            session()->flash('error', 'Not enough stock available!');
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'Failed to add product to bag!']);
        } elseif ($result) {
            $this->closeModal();
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
