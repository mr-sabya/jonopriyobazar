<?php

namespace App\Livewire\Backend\Order;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    // Table State
    public $search = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortDirection = 'desc';

    // Tab Filter State ('all', '0', '1', '2', '3', '4')
    public $statusFilter = 'all';

    protected $paginationTheme = 'bootstrap';

    // Reset pagination when filter or search changes
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function setFilter($status)
    {
        $this->statusFilter = $status;
    }

    public function sortBy($field)
    {
        $this->sortDirection = ($this->sortField === $field && $this->sortDirection === 'asc') ? 'desc' : 'asc';
        $this->sortField = $field;
    }

    public function render()
    {
        // 1. Create a base query with the common requirements
        // If you want to show ALL orders (even those without customers), REMOVE ->has('customer')
        $baseQuery = Order::where('type', 'product');

        // 2. Get counts based on that base query
        $counts = (clone $baseQuery)->selectRaw("
            count(*) as total,
            sum(case when status = 0 then 1 else 0 end) as pending,
            sum(case when status = 1 then 1 else 0 end) as received,
            sum(case when status = 2 then 1 else 0 end) as packed,
            sum(case when status = 3 then 1 else 0 end) as delivered,
            sum(case when status = 4 then 1 else 0 end) as canceled
        ")->first();

        // 3. Now build the table query using the same base
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
