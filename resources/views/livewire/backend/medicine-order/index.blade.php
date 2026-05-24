<div class="container-fluid py-4">
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

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search Invoice/Name/Phone...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Time/Area</th>
                            <th>Invoice</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $index => $order)
                        <tr wire:key="med-{{ $order->id }}">
                            <td>{{ $orders->firstItem() + $index }}</td>
                            <td>
                                <small class="fw-bold">{{ $order->shippingAddress['city']['name'] ?? 'N/A' }}</small><br>
                                <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                            </td>
                            <td><span class="badge bg-light text-dark border">#{{ $order->invoice }}</span></td>
                            <td>{{ $order->customer->name }}<br><small class="text-muted">{{ $order->customer->phone }}</small></td>
                            <td class="fw-bold">{{ number_format($order->grand_total, 2) }}</td>
                            <td><small class="text-uppercase fw-bold">{{ $order->payment_option->shortLabel() }}</small></td>
                            <td>{!! $order->status->badge() !!}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.order.medicine.show', $order->id) }}" wire:navigate class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $orders->links() }}
        </div>
    </div>
</div>