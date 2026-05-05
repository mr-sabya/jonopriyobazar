<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0 text-dark">
                Invoice #{{ $order->invoice }}
                <span class="ms-2">{!! $order->status->badge() !!}</span>
            </h4>
            <span class="badge bg-light text-muted border">Placed: {{ $order->created_at->format('d M, Y h:i A') }}</span>
        </div>
        <div class="btn-group shadow-sm">
            <a href="{{ route('admin.order.download', $order->id) }}" class="btn btn-white border"><i class="fas fa-download me-2"></i>PDF</a>
            <a href="{{ route('admin.order.index') }}" wire:navigate class="btn btn-primary ms-2 rounded"><i class="fas fa-list me-2"></i>Orders</a>
        </div>
    </div>

    <div class="row">
        <!-- Main Order Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 border-end">
                            <h6 class="fw-bold text-uppercase text-muted small mb-3">Shipping Details</h6>
                            <p class="mb-1 fw-bold text-dark">{{ $order->shippingAddress['name'] ?? 'N/A' }}</p>
                            <p class="small text-muted mb-2">
                                {{ $order->shippingAddress['street'] }}, {{ $order->shippingAddress['city']['name'] ?? '' }}<br>
                                {{ $order->shippingAddress['thana']['name'] ?? '' }}, {{ $order->shippingAddress['district']['name'] ?? '' }}
                            </p>
                            <span class="badge bg-warning-soft text-warning border border-warning px-3 rounded-pill">{{ strtoupper($order->shippingAddress['type'] ?? 'Home') }}</span>
                        </div>
                        <div class="col-md-6 ps-md-4">
                            <h6 class="fw-bold text-uppercase text-muted small mb-3">Customer Information</h6>
                            <p class="mb-1 fw-bold text-dark">{{ $order->customer['name'] }}</p>
                            <p class="small text-muted mb-1"><i class="fas fa-phone me-2 text-primary"></i>{{ $order->customer['phone'] }}</p>
                            <p class="small text-muted mb-3">
                                <i class="fas fa-wallet me-2 text-success"></i>
                                <span class="text-capitalize">{{ $order->payment_option }} Payment</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Product</th>
                                <th>Qty</th>
                                <th class="text-end">Unit</th>
                                <th class="text-end pe-4">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('upload/images/'.$item->product['image']) }}" class="rounded border me-3" width="50" height="50" style="object-fit: cover;">
                                        <div>
                                            <span class="fw-bold d-block text-dark">{{ $item->product['name'] }}</span>
                                            <small class="text-muted">Stock: {{ $item->product['quantity'] }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="fw-bold text-muted">{{ $item->quantity }}</td>
                                <td class="text-end">
                                    @php
                                    $unitPrice = $order->payment_option == 'wallet' ? $item->product['actual_price'] : $item->product['sale_price'];
                                    @endphp
                                    {{ number_format($unitPrice, 2) }}
                                </td>
                                <td class="text-end pe-4 fw-bold text-primary">{{ number_format($item->price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Totals Footer -->
                <div class="card-footer bg-white border-0 p-4">
                    <div class="row justify-content-end">
                        <div class="col-md-5">
                            <div class="d-flex justify-content-between mb-2 text-muted">
                                <span>Sub Total</span>
                                <strong>{{ number_format($order->sub_total, 2) }} ৳</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2 text-muted">
                                <span>Coupon</span>
                                <span class="text-danger">- {{ $order->cupon ? number_format($order->cupon['amount'], 2) : '0.00' }} ৳</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 text-muted">
                                <span>Delivery</span>
                                <span>+ {{ number_format($order->shippingAddress['city']['delivery_charge'] ?? 0, 2) }} ৳</span>
                            </div>
                            <hr class="my-3">
                            <div class="d-flex justify-content-between h5 fw-bold text-primary">
                                <span>Total</span>
                                <span>{{ number_format($order->grand_total, 2) }} ৳</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Status Control -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 fw-bold border-bottom-0">Process Order</div>
                <div class="card-body pt-0">
                    @foreach(\App\Enums\OrderStatus::cases() as $statusEnum)
                    @if($statusEnum === \App\Enums\OrderStatus::CANCELED)
                    <hr class="my-4">
                    @endif

                    @php
                    // Logic: Disable button if status is already completed or if order is in a final state
                    $isCurrentOrPast = ($order->status->value >= $statusEnum->value && $statusEnum !== \App\Enums\OrderStatus::CANCELED);

                    // If finalized (Delivered or Canceled), everything is disabled
                    $isOrderDone = $order->status->isFinalized();

                    // Cancel logic: Cannot cancel after delivery
                    $isCancelLocked = ($order->status === \App\Enums\OrderStatus::DELIVERED && $statusEnum === \App\Enums\OrderStatus::CANCELED);

                    // Current UI highlights
                    $isCurrent = ($order->status === $statusEnum);
                    @endphp

                    <button
                        wire:key="status-btn-{{ $statusEnum->value }}"
                        wire:click="updateStatus({{ $statusEnum->value }})"
                        @disabled($isCurrentOrPast || $isOrderDone || $isCancelLocked)
                        class="btn w-100 mb-2 py-3 position-relative shadow-none border-2 
                            {{ $isCurrent ? 'btn-'.$statusEnum->color().' border-0 text-white' : ($isCurrentOrPast ? 'btn-outline-'.$statusEnum->color().' opacity-50' : 'btn-outline-primary border-dashed') }}">

                        <span wire:loading wire:target="updateStatus({{ $statusEnum->value }})" class="spinner-border spinner-border-sm me-2"></span>

                        @if($isCurrent)
                        <i class="fas fa-check-circle me-1"></i>
                        @elseif($isCurrentOrPast)
                        <i class="fas fa-history me-1"></i>
                        @endif

                        {{ $statusEnum->label() }}
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- History Log -->
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-white py-3 fw-bold border-bottom-0">Action Timeline</div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush small">
                        @forelse($order->history->sortByDesc('created_at') as $log)
                        <li class="list-group-item d-flex justify-content-between py-3 border-light bg-transparent">
                            <div>
                                @php $logEnum = \App\Enums\OrderStatus::tryFrom($log->status_id); @endphp
                                <div class="fw-bold text-dark">{{ $logEnum ? $logEnum->label() : 'Status Update' }}</div>
                                <div class="text-muted"><i class="far fa-clock me-1 text-primary"></i>{{ $log->date_time->format('d M, h:i A') }}</div>
                            </div>
                            <span class="text-muted small text-end">{{ $log->date_time->diffForHumans() }}</span>
                        </li>
                        @empty
                        <li class="list-group-item text-center py-4 text-muted">No activity logged yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <style>
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

        .border-dashed {
            border-style: dashed !important;
        }

        .border-2 {
            border-width: 2px !important;
        }

        .btn-white {
            background: #fff;
            color: #333;
        }

        .btn-white:hover {
            background: #f8f9fa;
        }
    </style>
</div>

@push('scripts')
<script>
    $wire.on('swal', (data) => {
        const payload = data[0];
        Swal.fire({
            title: payload.type === 'success' ? 'Updated!' : 'Error',
            text: payload.message,
            icon: payload.type,
            confirmButtonColor: '#0d6efd',
            timer: 3000
        });
    });
</script>
@endpush