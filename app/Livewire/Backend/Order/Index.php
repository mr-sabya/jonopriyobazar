<?php

namespace App\Livewire\Backend\Order;

use App\Models\Order;
use App\Enums\OrderStatus; // Import the Enum
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortDirection = 'desc';

    // Tab Filter State ('all', or integer value from Enum)
    public $statusFilter = 'all';

    protected $paginationTheme = 'bootstrap';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function setFilter($status)
    {
        $this->statusFilter = $status;
        $this->resetPage();
    }

    public function sortBy($field)
    {
        $this->sortDirection = ($this->sortField === $field && $this->sortDirection === 'asc') ? 'desc' : 'asc';
        $this->sortField = $field;
    }

    public function render()
    {
        $baseQuery = Order::where('type', 'product');

        // Get counts using Enum values for database consistency
        $counts = (clone $baseQuery)->selectRaw("
            count(*) as total,
            sum(case when status = " . OrderStatus::PENDING->value . " then 1 else 0 end) as pending,
            sum(case when status = " . OrderStatus::RECEIVED->value . " then 1 else 0 end) as received,
            sum(case when status = " . OrderStatus::PACKED->value . " then 1 else 0 end) as packed,
            sum(case when status = " . OrderStatus::PROCESSING->value . " then 1 else 0 end) as processing,
            sum(case when status = " . OrderStatus::DELIVERED->value . " then 1 else 0 end) as delivered,
            sum(case when status = " . OrderStatus::CANCELED->value . " then 1 else 0 end) as canceled
        ")->first();

        $query = $baseQuery->with(['customer', 'shippingAddress.city']);

        // Apply Tab Filter
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        // Apply Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('invoice', 'like', '%' . $this->search . '%')
                    ->orWhereHas('customer', function ($c) {
                        $c->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('phone', 'like', '%' . $this->search . '%');
                    });
            });
        }

        $orders = $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.backend.order.index', [
            'orders' => $orders,
            'counts' => $counts
        ]);
    }
}
