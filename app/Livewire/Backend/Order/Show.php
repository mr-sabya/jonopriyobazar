<?php

namespace App\Livewire\Backend\Order;

use App\Models\Order;
use App\Traits\ManagesOrderStatuses; // Use the central Trait
use Livewire\Component;

class Show extends Component
{
    use ManagesOrderStatuses; // Logic for rewards, refunds, and history is here

    public $orderId;

    /**
     * Mount the component
     */
    public function mount($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Triggered by the status buttons in the UI
     */
    public function updateStatus($statusValue)
    {
        dd($statusValue); // Debugging line to check the incoming status value
        // This calls the method inside the Trait (ManagesOrderStatuses)
        // It handles: History Log, Wallet Deduction (on Delivery), 
        // Wallet Refund (on Cancel), Points, and Referral commissions.
        $this->updateOrderStatus($this->orderId, $statusValue);
    }

    /**
     * Render the view
     */
    public function render()
    {
        return view('livewire.backend.order.show', [
            'order' => Order::with([
                'items.product',
                'customer',
                'shippingAddress.city',
                'shippingAddress.thana',
                'shippingAddress.district',
                'billingAddress',
                'history.status',
                'cupon'
            ])->findOrFail($this->orderId),
        ]);
    }
}
