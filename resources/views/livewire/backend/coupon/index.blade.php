<div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <!-- Header -->
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold text-primary">Coupon Management</h5>
                    @can('admin.coupon.create')
                        <button wire:click="openModal" class="btn btn-primary btn-sm px-3 shadow-sm">
                            <i class="fas fa-plus me-1"></i> Create Coupon
                        </button>
                    @endcan
                </div>

                <div class="card-body">
                    <!-- Custom Datatable Header -->
                    <div class="row g-3 mb-4 mt-1">
                        <div class="col-md-1">
                            <select wire:model.live="perPage" class="form-select form-select-sm shadow-none">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <div class="col-md-7"></div>
                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white border-end-0"><i
                                        class="fas fa-search text-muted"></i></span>
                                <input type="text" wire:model.live.debounce.300ms="search"
                                    class="form-control border-start-0 ps-0 shadow-none"
                                    placeholder="Search by code...">
                            </div>
                        </div>
                    </div>

                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Professional Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle border-light">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th style="cursor:pointer" wire:click="sortBy('code')">
                                        Coupon Code @include('livewire.partials._sort-icon', ['field' => 'code'])
                                    </th>
                                    <th style="cursor:pointer" wire:click="sortBy('amount')">
                                        Amount @include('livewire.partials._sort-icon', ['field' => 'amount'])
                                    </th>
                                    <th style="cursor:pointer" wire:click="sortBy('expire_date')">
                                        Expires On @include('livewire.partials._sort-icon', ['field' => 'expire_date'])
                                    </th>
                                    <th>Limit</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($coupons as $index => $coupon)
                                    <tr>
                                        <td class="text-muted small">{{ $coupons->firstItem() + $index }}</td>
                                        <td><span class="fw-bold font-monospace text-uppercase">{{ $coupon->code }}</span>
                                        </td>
                                        <td class="fw-bold text-success">{{ number_format($coupon->amount, 2) }}</td>
                                        <td class="text-muted small">{{ date('d M, Y', strtotime($coupon->expire_date)) }}
                                        </td>
                                        <td>{{ $coupon->limit == 0 ? 'Unlimited' : $coupon->limit }}</td>
                                        <td>
                                            @if(strtotime($coupon->expire_date) < time())
                                                <span
                                                    class="badge bg-danger-soft text-danger border border-danger rounded-pill">Expired</span>
                                            @else
                                                <span
                                                    class="badge bg-success-soft text-success border border-success rounded-pill">Active</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group shadow-sm rounded border">
                                                <button wire:click="edit({{ $coupon->id }})"
                                                    class="btn btn-sm btn-white border-0"><i
                                                        class="fas fa-edit text-primary"></i></button>
                                                <button
                                                    onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                                    wire:click="delete({{ $coupon->id }})"
                                                    class="btn btn-sm btn-white border-0"><i
                                                        class="fas fa-trash text-danger"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted small">No coupons found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $coupons->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Coupon Modal -->
    <div wire:ignore.self class="modal fade" id="couponModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form wire:submit.prevent="save">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header border-bottom-0 p-4 pb-0">
                        <h5 class="modal-title fw-bold text-primary">{{ $isEditMode ? 'Update' : 'Create' }} Coupon</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            wire:click="resetFields"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">Coupon Code</label>
                                <input type="text" wire:model="code"
                                    class="form-control @error('code') is-invalid @enderror" placeholder="SUMMER2024">
                                @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Discount Amount</label>
                                <input type="number" wire:model="amount"
                                    class="form-control @error('amount') is-invalid @enderror" placeholder="0.00">
                                @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Usage Limit</label>
                                <input type="number" wire:model="limit"
                                    class="form-control @error('limit') is-invalid @enderror">
                                <small class="text-muted">0 for unlimited</small>
                                @error('limit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">Expiry Date</label>
                                <input type="date" wire:model="expire_date"
                                    class="form-control @error('expire_date') is-invalid @enderror">
                                @error('expire_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 bg-light p-3">
                        <button type="button" class="btn btn-white shadow-none text-muted" data-bs-dismiss="modal"
                            wire:click="resetFields">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm" wire:loading.attr="disabled">
                            <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-1"></span>
                            {{ $isEditMode ? 'Update Coupon' : 'Save Coupon' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            window.addEventListener('openCouponModal', event => {
                var myModal = new bootstrap.Modal(document.getElementById('couponModal'));
                myModal.show();
            });
            window.addEventListener('closeCouponModal', event => {
                bootstrap.Modal.getInstance(document.getElementById('couponModal')).hide();
            });
        </script>
    @endpush
</div>