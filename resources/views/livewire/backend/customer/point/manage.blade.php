<div>
    <div class="row g-4">
        <!-- Total Points Stats Card -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-body text-center bg-primary-subtle py-4">
                    <h6 class="text-primary text-uppercase small fw-bold mb-1">Total Points Available</h6>
                    <h2 class="fw-bold text-primary mb-0">
                        <i class="ri-copper-coin-line"></i> {{ number_format($user->point) }}
                    </h2>
                </div>
            </div>
        </div>

        <!-- Point History List -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="ri-history-line me-2"></i> Point Accumulation History</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3" width="10%">#</th>
                                    <th width="30%">Date</th>
                                    <th width="30%">Order Reference</th>
                                    <th class="text-end pe-3" width="30%">Points</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($history as $index => $item)
                                <tr>
                                    <td class="ps-3 text-muted">{{ $history->firstItem() + $index }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($item->date)->format('d-M-Y') }}</div>
                                        <div class="small text-muted">{{ \Carbon\Carbon::parse($item->date)->format('h:i A') }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2">
                                            #{{ $item->order->invoice ?? 'Manual/System' }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <span class="fw-bold {{ $item->point > 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $item->point > 0 ? '+' : '' }}{{ number_format($item->point) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <div class="mb-2"><i class="ri-copper-coin-line ri-2x opacity-50"></i></div>
                                        No point history found for this user.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if($history->hasPages())
                <div class="card-footer bg-white py-3">
                    {{ $history->links() }}
                </div>
                @endif
            </div>
        </div>

    </div>
</div>