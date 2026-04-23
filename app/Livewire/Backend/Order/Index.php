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
        // 1. Get counts for all statuses in ONE query (very efficient)
        $counts = Order::where('type', 'product')
            ->selectRaw("
            count(*) as total,
            sum(case when status = 0 then 1 else 0 end) as pending,
            sum(case when status = 1 then 1 else 0 end) as received,
            sum(case when status = 2 then 1 else 0 end) as packed,
            sum(case when status = 3 then 1 else 0 end) as delivered,
            sum(case when status = 4 then 1 else 0 end) as canceled
        ")
            ->first();

        // 2. Build the main query
        $query = Order::query()
            ->with(['customer', 'shippingAddress.city'])
            ->where('type', 'product');

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('invoice', 'like', '%' . $this->search . '%')
                    ->orWhereHas('customer', function ($c) {
                        $c->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        $orders = $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.backend.order.index', [
            'orders' => $orders,
            'counts' => $counts // Pass counts to the view
        ]);
    }
}