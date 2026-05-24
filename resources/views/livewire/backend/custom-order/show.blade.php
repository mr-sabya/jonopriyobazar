<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0 text-dark">
                Custom Invoice #{{ $order->invoice }}
                <span class="ms-2">{!! $order->status->badge() !!}</span>
            </h4>
            <span class="badge bg-light text-muted border">Placed: {{ $order->created_at->format('d M, Y h:i A') }}</span>
        </div>
        <div class="btn-group shadow-sm">
            <button class="btn btn-white border"><i class="fas fa-print me-2"></i>Print</button>
            <a href="{{ route('admin.order.customorder.index') }}" wire:navigate class="btn btn-primary ms-2 rounded"><i class="fas fa-arrow-left me-2"></i>Back to List</a>
        </div>
    </div>

    <div class="row">
        <!-- Main Order Content -->
        <div class="col-lg-8">
            <!-- Customer & Shipping Card -->
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
                            <span class="badge bg-warning-soft text-warning border border-warning px-3 rounded-pill">
                                {{ strtoupper($order->shippingAddress['type'] ?? 'Home') }}
                            </span>
                        </div>
                        <div class="col-md-6 ps-md-4">
                            <h6 class="fw-bold text-uppercase text-muted small mb-3">Customer Info & Wallet</h6>
                            <p class="mb-1 fw-bold text-dark">{{ $order->customer['name'] }}</p>
                            <p class="small text-muted mb-1"><i class="fas fa-phone me-2"></i>{{ $order->customer['phone'] }}</p>

                            <div class="d-flex mt-3">
                                <div class="me-3 p-2 bg-light rounded text-center border">
                                    <small class="d-block text-muted">Credit Wallet</small>
                                    <span class="fw-bold text-primary">{{ number_format($order->customer['wallet_balance'], 2) }}৳</span>
                                </div>
                                <div class="p-2 bg-light rounded text-center border">
                                    <small class="d-block text-muted">Refer Wallet</small>
                                    <span class="fw-bold text-success">{{ number_format($order->customer['ref_balance'], 2) }}৳</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Custom Content Area -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="m-0 fw-bold">Order Requirements</h6>
                </div>
                <div class="card-body">
                    <div class="bg-light p-3 rounded mb-4 border text-dark shadow-inner">
                        {!! $order->custom !!}
                    </div>

                    @if($order->image)
                    <div class="text-center">
                        <h6 class="small text-muted text-uppercase fw-bold mb-2">Attached Reference Image</h6>
                        <a href="{{ asset('upload/images/'.$order->image) }}" target="_blank">
                            <img src="{{ asset('upload/images/'.$order->image) }}" class="img-fluid rounded border shadow-sm" style="max-height: 450px">
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Pricing Update Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="m-0 fw-bold">Billing Adjustment</h6>
                </div>
                <div class="card-body">
                    <fieldset {{ $order->status->isFinalized() ? 'disabled' : '' }}>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="small fw-bold text-muted">Items Total</label>
                                <div class="input-group">
                                    <input type="number" wire:model.live="total" class="form-control shadow-none">
                                    <span class="input-group-text">৳</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold text-muted">Delivery Charge</label>
                                <input type="text" class="form-control bg-light" value="{{ number_format($delivery_charge, 2) }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold text-muted">Payment Method</label>
                                <select wire:model="payment_option" class="form-select shadow-none">
                                    <option value="cash">Cash On Delivery</option>
                                    <option value="wallet">Credit Wallet</option>
                                    <option value="refer">Refer Wallet</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>

                    <div class="d-flex justify-content-between align-items-center mt-4 p-3 bg-primary-soft rounded border border-primary border-opacity-10">
                        <span class="h5 mb-0 fw-bold text-primary">Grand Total: {{ number_format($grand_total, 2) }} ৳</span>
                        @if(!$order->status->isFinalized())
                        <button wire:click="saveFinancials" class="btn btn-primary px-4 shadow-sm">
                            <i class="fas fa-save me-2"></i>Save & Charge
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar: Status & History -->
        <div class="col-lg-4">
            <!-- Status Controls -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 fw-bold border-bottom-0">Process Order</div>
                <div class="card-body pt-0">
                    @foreach(\App\Enums\OrderStatus::cases() as $statusEnum)
                    @if($statusEnum === \App\Enums\OrderStatus::CANCELED)
                    <hr class="my-4">
                    @endif

                    @php
                    // 1. Is this status the same as or 'lower' than the current status?
                    // (e.g., if order is at 2, then 0, 1, and 2 are disabled)
                    $isCompletedOrCurrent = ($order->status->value >= $statusEnum->value);

                    // 2. Special Logic for Canceled:
                    // If the order is already Delivered (4), you cannot Cancel (5) it anymore.
                    $isCancelAfterDelivery = ($order->status === \App\Enums\OrderStatus::DELIVERED && $statusEnum === \App\Enums\OrderStatus::CANCELED);

                    // 3. Special Logic for everything else:
                    // If the order is already Canceled (5), everything must be disabled.
                    $isOrderCanceled = ($order->status === \App\Enums\OrderStatus::CANCELED);

                    // Combine all logic
                    $shouldBeDisabled = $isCompletedOrCurrent || $isCancelAfterDelivery || $isOrderCanceled;

                    // UI states for the CSS classes
                    $isCurrent = ($order->status === $statusEnum);
                    $wasReached = $order->history->pluck('status_id')->contains($statusEnum->value);
                    @endphp

                    <button
                        wire:key="status-{{ $statusEnum->value }}"
                        wire:click="updateStatus({{ $statusEnum->value }})"
                        @disabled($shouldBeDisabled)
                        class="btn w-100 mb-2 py-3 position-relative shadow-none border-2
                {{ $isCurrent ? 'btn-'.$statusEnum->color().' border-0 text-white' : ($wasReached ? 'btn-outline-'.$statusEnum->color().' opacity-75' : 'btn-outline-primary border-dashed') }}">

                        <span wire:loading wire:target="updateStatus({{ $statusEnum->value }})" class="spinner-border spinner-border-sm me-2"></span>

                        @if($isCurrent)
                        <i class="fas fa-check-circle me-1"></i>
                        @elseif($wasReached)
                        <i class="fas fa-history me-1"></i>
                        @endif

                        {{ $statusEnum->label() }}
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- History Logs -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 fw-bold border-bottom-0">Order Activity Logs</div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush small">
                        @forelse($order->history->sortByDesc('created_at') as $log)
                        <li class="list-group-item d-flex justify-content-between py-3 border-light bg-transparent">
                            <div>
                                @php
                                $logStatus = \App\Enums\OrderStatus::tryFrom($log->status_id);
                                @endphp
                                <div class="fw-bold text-dark">{{ $logStatus ? $logStatus->label() : 'Status Update' }}</div>
                                <div class="text-muted"><i class="far fa-clock me-1 text-primary"></i>{{ $log->date_time->format('d M, h:i A') }}</div>
                            </div>
                            <span class="text-muted small">{{ $log->date_time->diffForHumans() }}</span>
                        </li>
                        @empty
                        <li class="list-group-item text-center py-4 text-muted bg-transparent">No history found</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Professional Soft UI Helper Classes */
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

        .btn-white {
            background: #fff;
            color: #333;
        }

        .btn-white:hover {
            background: #f8f9fa;
        }

        .shadow-inner {
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05);
        }

        .opacity-75 {
            opacity: 0.75;
        }

        .border-2 {
            border-width: 2px !important;
        }
    </style>
</div>