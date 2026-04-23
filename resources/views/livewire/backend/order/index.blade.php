<div class="container-fluid py-4">
    <!-- Status Tabs -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-pills nav-fill bg-white p-2 rounded shadow-sm border">
                <li class="nav-item">
                    <button wire:click="setFilter('all')" class="nav-link {{ $statusFilter === 'all' ? 'active' : 'text-muted' }} shadow-none">
                        All <span class="badge {{ $statusFilter === 'all' ? 'bg-white text-primary' : 'bg-light text-dark' }} ms-1">{{ $counts->total }}</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button wire:click="setFilter('0')" class="nav-link {{ $statusFilter === '0' ? 'active bg-warning text-dark' : 'text-muted' }} shadow-none">
                        Pending <span class="badge {{ $statusFilter === '0' ? 'bg-dark text-white' : 'bg-warning-soft text-warning' }} ms-1">{{ $counts->pending }}</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button wire:click="setFilter('1')" class="nav-link {{ $statusFilter === '1' ? 'active' : 'text-muted' }} shadow-none">
                        Received <span class="badge {{ $statusFilter === '1' ? 'bg-white text-primary' : 'bg-primary-soft text-primary' }} ms-1">{{ $counts->received }}</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button wire:click="setFilter('2')" class="nav-link {{ $statusFilter === '2' ? 'active bg-info' : 'text-muted' }} shadow-none">
                        Packed <span class="badge {{ $statusFilter === '2' ? 'bg-white text-info' : 'bg-info-soft text-info' }} ms-1">{{ $counts->packed }}</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button wire:click="setFilter('3')" class="nav-link {{ $statusFilter === '3' ? 'active bg-success' : 'text-muted' }} shadow-none">
                        Delivered <span class="badge {{ $statusFilter === '3' ? 'bg-white text-success' : 'bg-success-soft text-success' }} ms-1">{{ $counts->delivered }}</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button wire:click="setFilter('4')" class="nav-link {{ $statusFilter === '4' ? 'active bg-danger' : 'text-muted' }} shadow-none">
                        Canceled <span class="badge {{ $statusFilter === '4' ? 'bg-white text-danger' : 'bg-danger-soft text-danger' }} ms-1">{{ $counts->canceled }}</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="m-0 fw-bold text-primary">Order Management</h5>
        </div>
        <div class="card-body">
            <!-- Table Controls -->
            <div class="row g-3 mb-4">
                <div class="col-md-1">
                    <select wire:model.live="perPage" class="form-select form-select-sm shadow-none">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="col-md-7"></div>
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control border-start-0 ps-0 shadow-none" placeholder="Search Invoice, Name, or Phone...">
                    </div>
                </div>
            </div>

            <!-- Custom Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle border-light">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">#</th>
                            <th style="cursor:pointer" wire:click="sortBy('created_at')">Time + Area</th>
                            <th>Invoice</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $index => $order)
                        <tr>
                            <td class="text-muted small">{{ $orders->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold small">{{ $order->created_at->format('d M, Y') }}</div>
                                <div class="text-muted small">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $order->shippingAddress['city']['name'] ?? 'N/A' }}
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border">#{{ $order->invoice }}</span></td>
                            <td>
                                <div class="fw-bold text-primary">{{ $order->customer['name'] }}</div>
                                <div class="small text-muted">{{ $order->customer['phone'] }}</div>
                            </td>
                            <td class="fw-bold">{{ number_format($order->grand_total, 2) }}</td>
                            <td>
                                @php
                                $methods = ['cash' => 'COD', 'wallet' => 'Wallet', 'refer' => 'Refer'];
                                $method = $methods[$order->payment_option] ?? $order->payment_option;
                                @endphp
                                <small class="text-muted fw-bold text-uppercase">{{ $method }}</small>
                            </td>
                            <td>
                                @switch($order->status)
                                @case(0) <span class="badge bg-warning-soft text-warning border border-warning rounded-pill">Pending</span> @break
                                @case(1) <span class="badge bg-primary-soft text-primary border border-primary rounded-pill">Received</span> @break
                                @case(2) <span class="badge bg-info-soft text-info border border-info rounded-pill">Packed</span> @break
                                @case(3) <span class="badge bg-success-soft text-success border border-success rounded-pill">Delivered</span> @break
                                @case(4) <span class="badge bg-danger-soft text-danger border border-danger rounded-pill">Canceled</span> @break
                                @endswitch
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-sm btn-outline-primary shadow-none rounded-circle">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted small">No orders found matching the criteria.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>

@push('css')
<style>
    /* Professional Soft Badges */
    .bg-warning-soft {
        background-color: rgba(255, 193, 7, 0.1);
    }

    .bg-primary-soft {
        background-color: rgba(13, 110, 253, 0.1);
    }

    .bg-info-soft {
        background-color: rgba(13, 202, 240, 0.1);
    }

    .bg-success-soft {
        background-color: rgba(25, 135, 84, 0.1);
    }

    .bg-danger-soft {
        background-color: rgba(220, 53, 69, 0.1);
    }

    .nav-pills .nav-link {
        font-weight: 600;
        border: 1px solid transparent;
        margin: 0 2px;
    }

    .nav-pills .nav-link:not(.active):hover {
        background-color: #f8f9fa;
    }
</style>
@endpush