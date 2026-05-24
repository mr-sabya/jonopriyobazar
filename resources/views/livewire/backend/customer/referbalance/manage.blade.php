<div class="container-fluid py-4">
    <!-- Breadcrumb / Go Back -->
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('admin.customer.show', $user->id) }}" wire:navigate class="btn btn-link text-decoration-none p-0 fw-bold">
                <i class="ri-arrow-left-line"></i> Go Back to Profile
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- User Profile Info Card -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="text-center">
                        <div class="avatar position-relative d-inline-block">
                            @if($user->image == null)
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" class="rounded-circle border" width="100" alt="{{ $user->name }}">
                            @else
                            <img src="{{ url('upload/profile_pic', $user->image)}}" class="rounded-circle border" width="100" height="100" alt="{{ $user->name }}">
                            @endif

                            @if($user->is_varified == 1)
                            <span class="position-absolute bottom-0 end-0 bg-success rounded-circle p-1 border border-2 border-white">
                                <i class="ri-check-line text-white small"></i>
                            </span>
                            @else
                            <span class="position-absolute bottom-0 end-0 bg-danger rounded-circle p-1 border border-2 border-white">
                                <i class="ri-close-line text-white small"></i>
                            </span>
                            @endif
                        </div>
                        <div class="mt-2">
                            <h4 class="mb-0 fw-bold">{{ $user->name }}</h4>
                            <p class="text-muted small mb-2">{{ $user->phone }}</p>
                            <span class="badge {{ $user->status == 1 ? 'bg-success' : ($user->status == 2 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                {{ $user->status == 1 ? 'Active' : ($user->status == 2 ? 'Hold' : 'Deactive') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Refer Balance Stat -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-body text-center bg-success-subtle py-4">
                    <h6 class="text-success text-uppercase small fw-bold mb-1">Current Refer Balance</h6>
                    <h2 class="fw-bold text-success mb-0">৳ {{ number_format($user->ref_balance, 2) }}</h2>
                </div>
            </div>
        </div>

        <!-- Refer History Table -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="ri-history-line me-2"></i> Refer History Log</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">#</th>
                                    <th>Date</th>
                                    <th>Order Invoice</th>
                                    <th class="text-end pe-3">Earned Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($history as $index => $item)
                                <tr>
                                    <td class="ps-3 text-muted">{{ $history->firstItem() + $index }}</td>
                                    <td>
                                        <div class="fw-bold">{{ \Carbon\Carbon::parse($item->date)->format('d M, Y') }}</div>
                                        <div class="small text-muted">{{ \Carbon\Carbon::parse($item->date)->format('h:i A') }}</div>
                                    </td>
                                    <td>
                                        <span class="text-primary fw-bold">#{{ $item->order->invoice ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <span class="fw-bold text-success">+ ৳ {{ number_format($item->amount, 2) }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="ri-information-line ri-2x mb-2 d-block"></i>
                                        No refer history found for this customer.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination Footer -->
                @if($history->hasPages())
                <div class="card-footer bg-white py-3">
                    {{ $history->links() }}
                </div>
                @endif
            </div>
        </div>

    </div>
</div>