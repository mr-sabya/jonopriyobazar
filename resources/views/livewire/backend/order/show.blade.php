<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0 text-dark">Invoice #{{ $order->invoice }} {{ $order->status }}</h4>
            <span class="badge bg-light text-muted border">Placed: {{ $order->created_at->format('d M, Y h:i A') }}</span>
        </div>
        <div class="btn-group shadow-sm">
            <a href="{{ route('admin.order.download', $order->id) }}" class="btn btn-white border"><i class="fas fa-download me-2"></i>PDF</a>
            <a href="{{ route('admin.order.index') }}" wire:navigate class="btn btn-primary ms-2 rounded"><i class="fas fa-list me-2"></i>Orders</a>
        </div>
    </div>

    @if (session()->has('success')) <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div> @endif
    @if (session()->has('error')) <div class="alert alert-danger border-0 shadow-sm">{{ session('error') }}</div> @endif

    <div class="row">
        <!-- Order Content -->
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
                            <p class="small text-muted mb-1"><i class="fas fa-phone me-2"></i>{{ $order->customer['phone'] }}</p>
                            <p class="small text-muted mb-3"><i class="fas fa-wallet me-2"></i>{{ ucfirst($order->payment_option) }} Payment</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
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
                                        <img src="{{ asset('upload/images/'.$item->product['image']) }}" class="rounded border me-3" width="50">
                                        <div><span class="fw-bold d-block text-dark">{{ $item->product['name'] }}</span><small class="text-muted">{{ $item->product['quantity'] }}</small></div>
                                    </div>
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td class="text-end">{{ number_format($order->payment_option == 'wallet' ? $item->product['actual_price'] : $item->product['sale_price'], 2) }}</td>
                                <td class="text-end pe-4 fw-bold">{{ number_format($item->price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white border-0 p-4">
                    <div class="row justify-content-end">
                        <div class="col-md-5">
                            <div class="d-flex justify-content-between mb-2"><span>Sub Total</span><strong>{{ number_format($order->sub_total, 2) }}</strong></div>
                            <div class="d-flex justify-content-between mb-2"><span>Coupon</span><span class="text-danger">- {{ $order->cupon ? number_format($order->cupon['amount'], 2) : '0.00' }}</span></div>
                            <div class="d-flex justify-content-between mb-2"><span>Delivery</span><span>+ {{ number_format($order->shippingAddress['city']['delivery_charge'] ?? 0, 2) }}</span></div>
                            <hr>
                            <div class="d-flex justify-content-between h5 fw-bold text-primary"><span>Total</span><span>{{ number_format($order->grand_total, 2) }}</span></div>
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
                    @foreach($statuses as $status)
                    @if($status->slug == 'canceled')
                    <hr class="my-4"> @endif
                    @php
                    $achieved = $order->isActiveHistory($status->id);
                    $finalized = $order->isFinalized();
                    $disabled = $achieved || $finalized;
                    @endphp
                    <button wire:click="updateStatus({{ $status->id }})"
                        {{ $disabled ? 'disabled' : '' }}
                        class="btn w-100 mb-2 py-3 position-relative {{ $achieved ? 'btn-success border-0 shadow-none' : 'btn-outline-primary border-dashed' }} {{ ($disabled && !$achieved) ? 'opacity-50 grayscale cursor-not-allowed' : '' }}">
                        <span wire:loading wire:target="updateStatus({{ $status->id }})" class="spinner-border spinner-border-sm me-2"></span>
                        @if($achieved) <i class="fas fa-check-circle me-1"></i> @endif
                        {{ $status->name }}
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- History Log -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 fw-bold border-bottom-0">Order Logs</div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush small">
                        @foreach($order->history as $log)
                        <li class="list-group-item d-flex justify-content-between py-3 border-light">
                            <div>
                                <div class="fw-bold text-dark">{{ $log->status['name'] }}</div>
                                <div class="text-muted"><i class="far fa-clock me-1"></i>{{ $log->date_time->format('d M, h:i A') }}</div>
                            </div>
                            <span class="text-muted small">{{ $log->date_time->diffForHumans() }}</span>
                        </li>
                        @endforeach
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

        .border-dashed {
            border-style: dashed !important;
        }

        .grayscale {
            filter: grayscale(1);
        }

        .cursor-not-allowed {
            cursor: not-allowed !important;
        }
    </style>
</div>