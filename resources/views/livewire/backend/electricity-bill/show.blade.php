<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0 text-dark">Invoice #{{ $order->invoice }} {!! $order->status->badge() !!}</h4>
        <a href="{{ route('admin.order.electricity.index') }}" wire:navigate class="btn btn-primary rounded shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="row">
        <!-- Bill Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 fw-bold border-bottom">Bill Information</div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Company</th>
                                <th>Type</th>
                                <th>Phone Number</th>
                                <th>Meter/Customer No</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="align-middle">
                                <td>{{ $order->company->name ?? 'N/A' }}</td>
                                <td>{{ $order->company->type ?? 'N/A' }}</td>
                                <td>{{ $order->phone }}</td>
                                <td class="fw-bold">{{ $order->meter_no }}</td>
                                <td class="text-end fw-bold text-primary h5">{{ number_format($order->grand_total, 2) }} ৳</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 fw-bold">Customer Details</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 border-end">
                            <p class="mb-1 text-muted small text-uppercase fw-bold">Name</p>
                            <p class="fw-bold h6">{{ $order->customer->name }}</p>
                            <p class="mb-1 text-muted small text-uppercase fw-bold mt-3">Phone</p>
                            <p>{{ $order->customer->phone }}</p>
                        </div>
                        <div class="col-sm-6 ps-md-4">
                            <p class="mb-1 text-muted small text-uppercase fw-bold">Payment Method</p>
                            <span class="badge bg-primary-soft text-primary">{{ $order->payment_option->label() }}</span>
                            <p class="mb-1 text-muted small text-uppercase fw-bold mt-3">Placed On</p>
                            <p>{{ $order->created_at->format('d M, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 fw-bold">Process Bill</div>
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
                        class="btn w-100 mb-2 py-3 border-2 {{ $isCurrent ? 'btn-'.$st->color().' text-white' : ($isPast ? 'btn-outline-'.$st->color().' opacity-50' : 'btn-outline-primary border-dashed') }}">
                        <span wire:loading wire:target="updateStatus({{ $st->value }})" class="spinner-border spinner-border-sm me-2"></span>
                        {{ $st->label() }}
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- History -->
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-white py-3 fw-bold">History Log</div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush small">
                        @foreach($order->history->sortByDesc('created_at') as $log)
                        <li class="list-group-item d-flex justify-content-between bg-transparent">
                            <div>
                                <div class="fw-bold">{{ \App\Enums\OrderStatus::tryFrom($log->status_id)->label() }}</div>
                                <div class="text-muted"><i class="far fa-clock me-1 text-primary"></i>{{ $log->date_time->format('h:i A') }}</div>
                            </div>
                            <span class="text-muted">{{ $log->date_time->diffForHumans() }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>