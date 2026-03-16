<?php

namespace App\Livewire\Frontend\User\CancelOrder;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Default type to show
    public $type = 'product';

    // Reset pagination when switching types
    public function setType($type)
    {
        $this->type = $type;
        $this->resetPage();
    }

    public function render()
    {
        $orders = Order::where('user_id', Auth::id())
            ->where('status', 4) // Only Canceled
            ->where('type', $this->type)
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('livewire.frontend.user.cancel-order.index', [
            'orders' => $orders
        ]);
    }
}
