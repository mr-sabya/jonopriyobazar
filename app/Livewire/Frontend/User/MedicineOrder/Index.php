<?php

namespace App\Livewire\Frontend\User\MedicineOrder;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        // Get medicine orders for the logged-in user with pagination
        $orders = Order::where('user_id', Auth::id())
            ->where('type', 'medicine')
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('livewire.frontend.user.medicine-order.index', [
            'orders' => $orders
        ]);
    }
}
