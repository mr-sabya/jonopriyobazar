<div>
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Customer List</h5>
                    <div class="col-md-3">
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search name or phone...">
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">#</th>
                                    <th>Customer</th>
                                    <th>Verification</th>
                                    <th>Status</th>
                                    <th class="text-center">Refers</th>
                                    <th>Balances</th>
                                    <th>Created At</th>
                                    <th class="text-end pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $index => $customer)
                                <tr>
                                    <td class="ps-3">{{ $customers->firstItem() + $index }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $customer->name }}</div>
                                        <div class="small text-muted">{{ $customer->phone }}</div>
                                    </td>
                                    <td>
                                        @if($customer->is_varified == 1)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">Verified</span>
                                        @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Unverified</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($customer->status == 1)
                                        <span class="badge bg-success">Active</span>
                                        @elseif($customer->status == 2)
                                        <span class="badge bg-warning text-dark">Hold</span>
                                        @else
                                        <span class="badge bg-danger">Deactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill bg-info text-dark">{{ $customer->refers_count }}</span>
                                    </td>
                                    <td>
                                        <div class="small">Wallet: <strong>৳{{ number_format($customer->wallet_balance, 2) }}</strong></div>
                                        <div class="small text-primary">Refer: <strong>৳{{ number_format($customer->ref_balance, 2) }}</strong></div>
                                    </td>
                                    <td class="small">
                                        {{ $customer->created_at->format('d M, Y') }}<br>
                                        <span class="text-muted">{{ $customer->created_at->format('h:i A') }}</span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('admin.customer.show', $customer->id) }}" class="btn btn-sm btn-outline-primary" wire:navigate>
                                            <i class="ri-eye-line"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>