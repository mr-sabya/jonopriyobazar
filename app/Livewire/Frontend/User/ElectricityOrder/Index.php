<?php

namespace App\Livewire\Frontend\User\ElectricityOrder;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Property to hold the order for the modal
    public $selectedOrder;

    public function viewOrder($orderId)
    {
        // Find the order and load it into the state
        $this->selectedOrder = Order::find($orderId);

        // Trigger a browser event to show the Bootstrap modal
        $this->dispatch('show-details-modal');
    }

    public function render()
    {
        $orders = Order::where('user_id', Auth::id())
            ->where('type', 'electricity')
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('livewire.frontend.user.electricity-order.index', [
            'orders' => $orders
        ]);
    }
}
