<?php

namespace App\Livewire\Backend\ElectricityBill;

use App\Models\Order;
use App\Enums\OrderStatus;
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
        $this->statusFilter = (string)$status;
        $this->resetPage();
    }

    public function render()
    {
        $counts = DB::table('orders')
            ->where('type', 'electricity')
            ->selectRaw("
                count(*) as total,
                sum(case when status = " . OrderStatus::PENDING->value . " then 1 else 0 end) as pending,
                sum(case when status = " . OrderStatus::RECEIVED->value . " then 1 else 0 end) as received,
                sum(case when status = " . OrderStatus::PACKED->value . " then 1 else 0 end) as packed,
                sum(case when status = " . OrderStatus::PROCESSING->value . " then 1 else 0 end) as processing,
                sum(case when status = " . OrderStatus::DELIVERED->value . " then 1 else 0 end) as delivered,
                sum(case when status = " . OrderStatus::CANCELED->value . " then 1 else 0 end) as canceled
            ")->first();

        $orders = Order::with(['customer', 'company'])
            ->where('type', 'electricity')
            ->when($this->statusFilter !== 'all', fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->search, function ($q) {
                $q->where('invoice', 'like', '%' . $this->search . '%')
                    ->orWhereHas('customer', fn($sub) => $sub->where('name', 'like', '%' . $this->search . '%')->orWhere('phone', 'like', '%' . $this->search . '%'));
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.backend.electricity-bill.index', compact('orders', 'counts'));
    }
}
