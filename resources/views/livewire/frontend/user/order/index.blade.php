<div class="col-lg-8 col-xl-9">
    <!-- Header Section -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="font-weight-bold mb-0">Product Orders</h3>
        <span class="badge badge-soft-primary px-3 py-2 br-10">
            Total: {{ $orders->total() }} Orders
        </span>
    </div>

    <!-- Table Section -->
    <div class="card border-0 shadow-sm br-15 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 px-4 small font-weight-bold text-muted">#</th>
                        <th class="border-0 small font-weight-bold text-muted">DATE</th>
                        <th class="border-0 small font-weight-bold text-muted">ORDER#INVOICE</th>
                        <th class="border-0 text-center small font-weight-bold text-muted">AMOUNT</th>
                        <th class="border-0 small font-weight-bold text-muted">PAYMENT BY</th>
                        <th class="border-0 text-center small font-weight-bold text-muted">STATUS</th>
                        <th class="border-0 text-right px-4 small font-weight-bold text-muted">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="px-4 py-3 small text-muted">
                            {{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            <p class="font-weight-bold text-dark mb-0 small">
                                {{ date('d-m-Y', strtotime($order->created_at)) }}
                            </p>
                            <p class="small text-muted mb-0">{{ $order->created_at->diffForHumans() }}</p>
                        </td>
                        <td>
                            <a href="{{ route('user.order.show', $order->invoice)}}" class="font-weight-bold text-primary">
                                #{{ $order->invoice }}
                            </a>
                        </td>
                        <td class="text-center">
                            <span class="font-weight-bold text-dark">{{ number_format($order->grand_total, 2) }}৳</span>
                        </td>
                        <td>
                            <span class="small font-weight-bold">
                                @if($order->payment_option == 'cash')
                                <i class="fas fa-truck text-muted mr-1"></i> Cash On Delivery
                                @elseif($order->payment_option == 'wallet')
                                <i class="fas fa-wallet text-primary mr-1"></i> Credit Wallet
                                @elseif($order->payment_option == 'refer')
                                <i class="fas fa-users text-info mr-1"></i> Refer Balance
                                @else
                                {{ ucfirst($order->payment_option) }}
                                @endif
                            </span>
                        </td>
                        <td class="text-center">
                            @php
                            $statusMap = [
                            0 => ['label' => 'Pending', 'class' => 'badge-warning-light text-warning'],
                            1 => ['label' => 'Received', 'class' => 'badge-primary-light text-primary'],
                            2 => ['label' => 'Processing', 'class' => 'badge-info-light text-info'],
                            3 => ['label' => 'Completed', 'class' => 'badge-success-light text-success'],
                            4 => ['label' => 'Canceled', 'class' => 'badge-dark-light text-muted'],
                            ];
                            $currentStatus = $statusMap[$order->status] ?? ['label' => 'Unknown', 'class' => 'badge-secondary'];
                            @endphp
                            <span class="badge {{ $currentStatus['class'] }} px-2 py-2 br-10 w-100" style="max-width: 100px;">
                                {{ $currentStatus['label'] }}
                            </span>
                        </td>
                        <td class="text-right px-4">
                            <a href="{{ route('user.order.show', $order->invoice)}}" class="btn btn-sm btn-outline-primary br-10">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-shopping-basket fa-3x text-muted mb-3 opacity-25"></i>
                            <p class="text-muted">No orders found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
        <div class="card-footer bg-white border-0 pt-0 px-4 pb-4">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>