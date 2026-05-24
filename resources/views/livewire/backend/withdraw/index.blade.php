<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <!-- Card Header -->
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0 fw-bold text-dark">User Withdrawals</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted">
                                    <i class="ri-search-line"></i>
                                </span>
                                <input type="text" wire:model.live.debounce.300ms="search"
                                    class="form-control bg-light border-start-0"
                                    placeholder="Search by name or phone...">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body p-0">
                    <!-- Flash Messages -->
                    @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
                        <i class="ri-checkbox-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">#</th>
                                    <th>User Information</th>
                                    <th class="text-center">Requested Amount</th>
                                    <th class="text-center">Current Status</th>
                                    <th class="text-end pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($withdraws as $index => $withdraw)
                                <tr>
                                    <td class="ps-3 text-muted">{{ $withdraws->firstItem() + $index }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $withdraw->user['name'] }}</div>
                                        <div class="small text-muted">{{ $withdraw->user['phone'] }}</div>
                                    </td>
                                    <td class="text-center fw-bold text-primary">
                                        ৳ {{ number_format($withdraw->amount, 2) }}
                                    </td>
                                    <td class="text-center">
                                        @if($withdraw->status == 0)
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2">
                                            <i class="ri-time-line me-1"></i> Pending
                                        </span>
                                        @else
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                            <i class="ri-checkbox-circle-line me-1"></i> Completed
                                        </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-3">
                                        @if($withdraw->status == 0)
                                        <button
                                            wire:click="complete({{ $withdraw->id }})"
                                            wire:confirm="Confirm payment? This will deduct ৳{{ $withdraw->amount }} from the user's reference balance."
                                            class="btn btn-sm btn-success px-3">
                                            Mark Complete
                                        </button>
                                        @else
                                        <button class="btn btn-sm btn-light border disabled text-muted">
                                            Processed
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="ri-inbox-line ri-2x d-block mb-2"></i>
                                        No withdrawal requests found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if($withdraws->hasPages())
                <div class="card-footer bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="small text-muted mb-0">
                            Showing {{ $withdraws->firstItem() }} to {{ $withdraws->lastItem() }} of {{ $withdraws->total() }} requests
                        </p>
                        {{ $withdraws->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>