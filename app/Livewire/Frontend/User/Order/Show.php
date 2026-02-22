<?php

namespace App\Livewire\Frontend\User\Order;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public $order;

    public function mount($invoice)
    {
        // dd($invoice);
        // Fetch order with all necessary relations to avoid N+1 queries
        $this->order = Order::with(['items', 'items.product', 'histories.status', 'shippingAddress.city', 'billingAddress.city', 'cupon', 'company'])
            ->where('invoice', $invoice)
            ->where('user_id', Auth::id())
            ->firstOrFail();

            // dd($this->order);
    }

    public function render()
    {
        return view('livewire.frontend.user.order.show');// Or layouts.front depending on your setup
    }
}
