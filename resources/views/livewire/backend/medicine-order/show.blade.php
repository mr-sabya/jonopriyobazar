<div class="container-fluid py-4">
    <!-- Top Stats -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm bg-primary text-white text-center p-3">
                <small class="text-uppercase opacity-75">Credit Wallet</small>
                <h4 class="fw-bold mb-0">{{ number_format($order->customer->wallet_balance, 2) }} ৳</h4>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm bg-success text-white text-center p-3">
                <small class="text-uppercase opacity-75">Refer Wallet</small>
                <h4 class="fw-bold mb-0">{{ number_format($order->customer->ref_balance, 2) }} ৳</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Details Column -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 fw-bold">Medicine List & Requirements</div>
                <div class="card-body">
                    <div class="bg-light p-3 border rounded mb-4">{!! $order->custom !!}</div>
                    @if($order->image)
                    <img src="{{ asset('upload/images/'.$order->image) }}" class="img-fluid rounded border shadow-sm">
                    @endif
                </div>
            </div>

            <!-- Financials -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 fw-bold">Billing Adjustment</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="small fw-bold">Sub Total</label>
                            <input type="number" wire:model.live="total" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="small fw-bold">Delivery</label>
                            <input type="text" class="form-control bg-light" value="{{ $delivery_charge }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="small fw-bold">Payment Via</label>
                            <select wire:model="payment_option" class="form-select">
                                @foreach(\App\Enums\PaymentOption::cases() as $po)
                                <option value="{{ $po->value }}">{{ $po->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-between align-items-center p-3 bg-light rounded">
                        <h5 class="mb-0 fw-bold">Grand Total: {{ number_format($grand_total, 2) }} ৳</h5>
                        <button wire:click="saveFinancials" class="btn btn-success px-4">Save & Charge</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Column -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 fw-bold">Process Order</div>
                <div class="card-body">
                    @foreach(\App\Enums\OrderStatus::cases() as $st)
                    @if($st === \App\Enums\OrderStatus::CANCELED)
                    <hr> @endif
                    @php
                    $isCurrent = $order->status === $st;
                    $isDone = $order->status->isFinalized();
                    $isPast = $order->status->value >= $st->value && $st !== \App\Enums\OrderStatus::CANCELED;
                    @endphp
                    <button wire:click="updateStatus({{ $st->value }})"
                        @disabled($isCurrent || $isPast || $isDone)
                        class="btn w-100 mb-2 py-3 border-2 {{ $isCurrent ? 'btn-'.$st->color() : ($isPast ? 'btn-outline-'.$st->color().' opacity-50' : 'btn-outline-primary border-dashed') }}">
                        <span wire:loading wire:target="updateStatus({{ $st->value }})" class="spinner-border spinner-border-sm me-2"></span>
                        {{ $st->label() }}
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Activity Logs -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 fw-bold">Action Timeline</div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush small">
                        @foreach($order->history->sortByDesc('created_at') as $log)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ \App\Enums\OrderStatus::tryFrom($log->status_id)->label() }}</span>
                            <span class="text-muted">{{ $log->created_at->diffForHumans() }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>