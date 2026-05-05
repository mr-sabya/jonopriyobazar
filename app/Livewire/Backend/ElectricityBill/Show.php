<?php

namespace App\Livewire\Backend\ElectricityBill;

use App\Models\Order;
use App\Traits\ManagesOrderStatuses;
use Livewire\Component;

class Show extends Component
{
    use ManagesOrderStatuses;

    public $orderId;

    public function mount($id)
    {
        $this->orderId = $id;
    }

    public function updateStatus($statusValue)
    {
        // Trait method handles rewards, history, and DB updates
        $this->updateOrderStatus($this->orderId, $statusValue);
    }

    public function render()
    {
        return view('livewire.backend.electricity-bill.show', [
            'order' => Order::with(['customer', 'company', 'history.status'])->findOrFail($this->orderId)
        ]);
    }
}
