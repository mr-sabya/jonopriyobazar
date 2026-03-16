<div class="col-lg-9 pt-3">
    <!-- Header Section -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="font-weight-bold mb-0">Electricity Bills</h3>
        <span class="badge badge-soft-primary px-3 py-2 br-10">
            Total: {{ $orders->total() }} Bills
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
                            <p class="font-weight-bold text-dark mb-0 small">{{ date('d-m-Y', strtotime($order->created_at)) }}</p>
                            <p class="small text-muted mb-0">{{ $order->created_at->diffForHumans() }}</p>
                        </td>
                        <td>
                            <button wire:click="viewOrder({{ $order->id }})" class="btn btn-link p-0 font-weight-bold text-primary">
                                #{{ $order->invoice }}
                            </button>
                        </td>
                        <td class="text-center">
                            <span class="font-weight-bold text-dark">{{ number_format($order->grand_total, 2) }}৳</span>
                        </td>
                        <td>
                            <span class="small font-weight-bold">
                                @if($order->payment_option == 'cash')
                                <i class="fas fa-money-bill-wave text-muted mr-1"></i> Cash
                                @elseif($order->payment_option == 'wallet')
                                <i class="fas fa-wallet text-primary mr-1"></i> Wallet
                                @else
                                <i class="fas fa-users text-info mr-1"></i> Refer
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
                            $curr = $statusMap[$order->status] ?? ['label' => 'Unknown', 'class' => 'badge-secondary'];
                            @endphp
                            <span class="badge {{ $curr['class'] }} px-2 py-2 br-10 w-100" style="max-width: 100px;">
                                {{ $curr['label'] }}
                            </span>
                        </td>
                        <td class="text-right px-4">
                            <button wire:click="viewOrder({{ $order->id }})" class="btn btn-sm btn-outline-primary br-10">
                                <i class="fas fa-eye"></i> Quick View
                            </button>

                            <a href="{{ route('user.order.show', $order->invoice)}}" class="btn btn-sm btn-outline-primary br-10" wire:navigate>
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">No records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
        <div class="card-footer bg-white border-0 px-4 pb-4">{{ $orders->links() }}</div>
        @endif
    </div>

    <!-- Details Modal (Fully Livewire Controlled) -->
    <div wire:ignore.self class="modal fade" id="details_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow br-15">
                <div class="modal-header bg-light">
                    <h5 class="modal-title font-weight-bold">Bill Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($selectedOrder)
                    <!-- This replaces your old AJAX response -->
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="small text-muted mb-0">Invoice</label>
                            <p class="font-weight-bold">#{{ $selectedOrder->invoice }}</p>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="small text-muted mb-0">Total Amount</label>
                            <p class="font-weight-bold text-primary">{{ number_format($selectedOrder->grand_total, 2) }}৳</p>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted mb-0">Billing Details</label>
                            <div class="bg-light p-3 br-10">
                                {{-- Access your specific electricity bill fields here --}}
                                <p class="mb-1 small"><strong>Meter No:</strong> {{ $selectedOrder->meter_no ?? 'N/A' }}</p>
                                <p class="mb-1 small"><strong>Phone No:</strong> {{ $selectedOrder->phone ?? 'N/A' }}</p>
                                <p class="mb-0 small"><strong>Notes:</strong> {{ $selectedOrder->note ?? 'None' }}</p>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="text-center p-4">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Listen for the Livewire event
    window.addEventListener('show-details-modal', event => {
        $('#details_modal').modal('show');
    });
</script>