<?php

namespace App\Livewire\Backend\CustomOrder;

use App\Models\Order;
use App\Enums\OrderStatus; // Import the Enum
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['statusFilter', 'search'];

    public function setFilter($status)
    {
        $this->statusFilter = $status;
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'desc';
        }
    }

    public function render()
    {
        // 1. Calculate counts for the tabs using Enum values
        $counts = DB::table('orders')
            ->where('type', 'custom')
            ->selectRaw("
                count(*) as total,
                sum(case when status = " . OrderStatus::PENDING->value . " then 1 else 0 end) as pending,
                sum(case when status = " . OrderStatus::RECEIVED->value . " then 1 else 0 end) as received,
                sum(case when status = " . OrderStatus::PACKED->value . " then 1 else 0 end) as packed,
                sum(case when status = " . OrderStatus::PROCESSING->value . " then 1 else 0 end) as processing,
                sum(case when status = " . OrderStatus::DELIVERED->value . " then 1 else 0 end) as delivered,
                sum(case when status = " . OrderStatus::CANCELED->value . " then 1 else 0 end) as canceled
            ")->first();

        // 2. Build the query
        $orders = Order::with(['customer', 'shippingAddress.city'])
            ->where('type', 'custom')
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('invoice', 'like', '%' . $this->search . '%')
                        ->orWhereHas('customer', function ($sub) {
                            $sub->where('name', 'like', '%' . $this->search . '%')
                                ->orWhere('phone', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.backend.custom-order.index', compact('orders', 'counts'));
    }
}