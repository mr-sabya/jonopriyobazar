<div class="container-fluid py-4">
    <!-- Filter Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <!-- Search -->
                <div class="col-md-3">
                    <label class="small fw-bold text-muted">Search User</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control border-start-0 ps-0 shadow-none" placeholder="Name or Phone...">
                    </div>
                </div>

                <!-- Expiration Status -->
                <div class="col-md-2">
                    <label class="small fw-bold text-muted">Expiration</label>
                    <select wire:model.live="expiration" class="form-select shadow-none">
                        <option value="">All Status</option>
                        <option value="0">Active (Not Expired)</option>
                        <option value="1">Expired</option>
                    </select>
                </div>

                <!-- Hold Status -->
                <div class="col-md-2">
                    <label class="small fw-bold text-muted">Hold Status</label>
                    <select wire:model.live="hold_status" class="form-select shadow-none">
                        <option value="">All Status</option>
                        <option value="0">Running</option>
                        <option value="1">On Hold</option>
                    </select>
                </div>

                <!-- Package Filter -->
                <div class="col-md-3">
                    <label class="small fw-bold text-muted">Package</label>
                    <select wire:model.live="package_id" class="form-select shadow-none">
                        <option value="">All Packages</option>
                        @foreach($packages as $pkg)
                        <option value="{{ $pkg->id }}">{{ $pkg->amount }} ৳ ({{ $pkg->validate }} Days)</option>
                        @endforeach
                    </select>
                </div>

                <!-- Reset Button -->
                <div class="col-md-2 d-flex align-items-end">
                    <button wire:click="resetFilters" class="btn btn-light w-100 border shadow-none">
                        <i class="fas fa-redo me-1"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- User Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-primary">Credit Wallet User List</h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>User Info</th>
                            <th>Wallet Status</th>
                            <th>Package Info</th>
                            <th>Expire On</th>
                            <th>Financials (Pur. / Pay / Due)</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        @php
                        $activePkg = $user->userPackages->first();
                        $due = ($user->total_purchase ?? 0) - ($user->total_pay ?? 0);
                        @endphp
                        <tr wire:key="user-{{ $user->id }}">
                            <td class="ps-4">{{ $users->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold">{{ $user->name }}</div>
                                <div class="small text-muted">{{ $user->phone }}</div>
                            </td>
                            <td>
                                <!-- Hold Badge -->
                                @if($user->is_hold)
                                <span class="badge bg-warning-soft text-warning">Hold</span>
                                @else
                                <span class="badge bg-success-soft text-success">Running</span>
                                @endif

                                <!-- Expiration Badge -->
                                @if($user->is_expired)
                                <span class="badge bg-danger-soft text-danger">Expired</span>
                                @endif
                            </td>
                            <td>
                                @if($user->wallet_package_id)
                                <div class="fw-bold text-dark">{{ $user->activePackage->amount ?? 0 }} ৳</div>
                                <div class="small text-muted">{{ $user->activePackage->validate ?? 0 }} Days</div>
                                @else
                                <span class="text-muted small italic">None</span>
                                @endif
                            </td>
                            <td>
                                @if($activePkg)
                                <div class="{{ $user->is_expired ? 'text-danger fw-bold' : '' }}">
                                    {{ date('d-M-Y', strtotime($activePkg->valid_to)) }}
                                </div>
                                @else
                                <span class="text-muted small">---</span>
                                @endif
                            </td>
                            <td>
                                <div class="small">
                                    <span class="text-muted">Pur:</span> <span class="fw-bold">{{ number_format($user->total_purchase ?? 0) }}</span>
                                </div>
                                <div class="small">
                                    <span class="text-muted">Pay:</span> <span class="text-success fw-bold">{{ number_format($user->total_pay ?? 0) }}</span>
                                </div>
                                <div class="small">
                                    <span class="text-muted">Due:</span> <span class="text-danger fw-bold">{{ number_format($due) }}</span>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.wallet.user.show', $user->id) }}"
                                    class="btn btn-sm btn-info text-white rounded-circle shadow-sm"
                                    title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <p class="text-muted mb-0">No users found matching current filters.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-top">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>