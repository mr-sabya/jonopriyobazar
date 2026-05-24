<div>
    <!-- Stats Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body py-4">
                    <div class="row text-center">
                        <div class="col-md-4 border-end">
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Total Earning</p>
                            <h3 class="mb-0 text-primary">৳ {{ number_format($totalEarning, 2) }}</h3>
                        </div>
                        <div class="col-md-4 border-end">
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Total Withdraw</p>
                            <h3 class="mb-0 text-danger">৳ {{ number_format($totalWithdraw, 2) }}</h3>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1 small text-uppercase fw-bold">Current Balance</p>
                            <h3 class="mb-0 text-success">৳ {{ number_format($balance, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row g-4">
        <!-- Marketer Earnings List -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Marketer Earnings</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Order Invoice</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($percentages as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item->date)->format('d-M-Y') }}</td>
                                    <td>
                                        <a href="#" class="text-decoration-none fw-bold text-info">
                                            #{{ $item->order->invoice ?? 'N/A' }}
                                        </a>
                                    </td>
                                    <td class="text-end fw-bold">৳ {{ number_format($item->amount, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-3 text-muted">No earnings found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $percentages->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Marketer Withdraw List -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Withdraw History</h5>
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#marketerWithdrawModal">
                        <i class="ri-add-line"></i> Add Payment
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Method</th>
                                    <th>Amount</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($withdraws as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item->date)->format('d-M-Y') }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $item->method ?? 'N/A' }}</span></td>
                                    <td class="fw-bold text-danger">৳ {{ number_format($item->amount, 2) }}</td>
                                    <td class="text-end">
                                        <button wire:click="deleteWithdraw({{ $item->id }})"
                                            wire:confirm="Are you sure you want to delete this withdraw? The amount will be refunded to balance."
                                            class="btn btn-outline-danger btn-sm">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">No withdrawals found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $withdraws->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Withdraw Modal -->
    <div wire:ignore.self class="modal fade" id="marketerWithdrawModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success p-3">
                    <h5 class="modal-title text-white">Add Marketer Payment</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="store">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Date</label>
                            <input type="date" wire:model="date" class="form-control @error('date') is-invalid @enderror">
                            @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Amount (৳)</label>
                            <input type="number" step="0.01" wire:model="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="0.00">
                            @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Payment Method</label>
                            <input type="text" wire:model="method" class="form-control @error('method') is-invalid @enderror" placeholder="e.g. Bkash, Bank, Cash">
                            @error('method') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success px-4">Complete Withdraw</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('close-modal', event => {
            const modalEl = document.getElementById('marketerWithdrawModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
        });
    </script>
</div>