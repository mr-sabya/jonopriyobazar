<div class="container-fluid py-4">
    <!-- Status Tabs -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-pills nav-fill bg-white p-2 rounded shadow-sm border">
                {{-- All Tab --}}
                <li class="nav-item">
                    <button wire:click="setFilter('all')" class="nav-link {{ $statusFilter === 'all' ? 'active bg-primary' : 'text-muted' }} shadow-none">
                        All <span class="badge {{ $statusFilter === 'all' ? 'bg-white text-primary' : 'bg-light text-dark' }} ms-1">{{ $counts->total }}</span>
                    </button>
                </li>

                {{-- Dynamic Tabs from OrderStatus Enum --}}
                @foreach(\App\Enums\OrderStatus::cases() as $status)
                @php
                $slug = strtolower($status->name); // maps to 'pending', 'received', etc. in the counts object
                $countValue = $counts->$slug ?? 0;
                $isActive = (string)$statusFilter === (string)$status->value;
                @endphp
                <li class="nav-item">
                    <button wire:click="setFilter('{{ $status->value }}')"
                        class="nav-link {{ $isActive ? 'active bg-'.$status->color() : 'text-muted' }} shadow-none">
                        {{ $status->label() }}
                        <span class="badge {{ $isActive ? 'bg-white text-'.$status->color() : 'bg-'.$status->color().'-soft text-'.$status->color() }} ms-1">
                            {{ $countValue }}
                        </span>
                    </button>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="m-0 fw-bold text-primary">Custom Order Management</h5>
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
                            <th style="cursor:pointer" wire:click="sortBy('created_at')">
                                Time + Area
                                @if($sortField === 'created_at') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i> @endif
                            </th>
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
                        <tr wire:key="order-{{ $order->id }}">
                            <td class="text-muted small">{{ $orders->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold small">{{ $order->created_at->format('d M, Y') }}</div>
                                <div class="text-muted small">
                                    <i class="fas fa-map-marker-alt me-1 text-danger"></i>
                                    {{ $order->shippingAddress['city']['name'] ?? 'N/A' }}
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border">#{{ $order->invoice }}</span></td>
                            <td>
                                <div class="fw-bold text-primary">{{ $order->customer['name'] ?? 'Guest' }}</div>
                                <div class="small text-muted">{{ $order->customer['phone'] ?? 'N/A' }}</div>
                            </td>
                            <td class="fw-bold">{{ number_format($order->grand_total, 2) }} ৳</td>
                            <td>
                                <small class="text-muted fw-bold text-uppercase">
                                    {{ $order->payment_option->shortLabel() }}
                                </small>
                            </td>
                            <td>
                                {{-- ENUM POWER: Centralized badge logic --}}
                                {!! $order->status->badge() !!}
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.order.customorder.show', $order->id) }}" wire:navigate class="btn btn-sm btn-outline-primary shadow-none rounded-circle">
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
    /* Professional Soft UI Badges */
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

    .bg-secondary-soft {
        background-color: rgba(108, 117, 125, 0.1);
    }

    .nav-pills .nav-link {
        font-weight: 600;
        border: 1px solid transparent;
        margin: 0 2px;
        transition: all 0.3s ease;
    }

    .nav-pills .nav-link:not(.active):hover {
        background-color: #f8f9fa;
    }

    .nav-pills .nav-link.active {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    }

    .table th {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #6c757d;
    }

    .table td {
        font-size: 0.9rem;
    }
</style>
@endpush