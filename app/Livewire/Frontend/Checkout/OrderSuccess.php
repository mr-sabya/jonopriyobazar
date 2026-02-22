<?php

namespace App\Livewire\Frontend\Checkout;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderSuccess extends Component
{
    public $order;

    public function mount($order_id)
    {
        // Fetch order and ensure it belongs to the logged-in user
        $this->order = Order::where('id', $order_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.frontend.checkout.order-success');
    }
}
