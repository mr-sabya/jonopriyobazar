<?php

namespace App\Livewire\Frontend\User\CustomOrder;

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
        // Get custom orders for the logged-in user
        $orders = Order::where('user_id', Auth::id())
            ->where('type', 'custom')
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('livewire.frontend.user.custom-order.index', [
            'orders' => $orders
        ]);
    }
}
