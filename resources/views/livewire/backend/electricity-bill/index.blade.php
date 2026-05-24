<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark mb-0">Electricity Bill Management</h4>
        <input type="text" wire:model.live.debounce.300ms="search" class="form-control w-25 shadow-sm" placeholder="Search Invoice/Name/Phone...">
    </div>

    <!-- Filter Tabs -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-pills nav-fill bg-white p-2 rounded shadow-sm border">
                <li class="nav-item">
                    <button wire:click="setFilter('all')" class="nav-link {{ $statusFilter === 'all' ? 'active bg-primary' : 'text-muted' }}">
                        All ({{ $counts->total }})
                    </button>
                </li>
                @foreach(\App\Enums\OrderStatus::cases() as $status)
                @php $slug = strtolower($status->name); @endphp
                <li class="nav-item">
                    <button wire:click="setFilter('{{ $status->value }}')"
                        class="nav-link {{ (string)$statusFilter === (string)$status->value ? 'active bg-'.$status->color() : 'text-muted' }}">
                        {{ $status->label() }} ({{ $counts->$slug ?? 0 }})
                    </button>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Time</th>
                            <th>Invoice</th>
                            <th>Customer</th>
                            <th>Company</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $index => $order)
                        <tr wire:key="bill-{{ $order->id }}">
                            <td class="ps-4 small text-muted">{{ $orders->firstItem() + $index }}</td>
                            <td><small>{{ $order->created_at->diffForHumans() }}</small></td>
                            <td><span class="badge bg-light text-dark border">#{{ $order->invoice }}</span></td>
                            <td>
                                <div class="fw-bold">{{ $order->customer->name }}</div>
                                <small class="text-muted">{{ $order->customer->phone }}</small>
                            </td>
                            <td>{{ $order->company->name ?? 'N/A' }}</td>
                            <td class="fw-bold">{{ number_format($order->grand_total, 2) }} ৳</td>
                            <td>{!! $order->status->badge() !!}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.order.electricity.show', $order->id) }}" wire:navigate class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0">{{ $orders->links() }}</div>
    </div>
</div>