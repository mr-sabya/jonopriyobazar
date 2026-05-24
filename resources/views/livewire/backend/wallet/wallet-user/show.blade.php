<div class="customer">
    <!-- Top Stats -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-3 border-end">
                            <h6 class="text-muted mb-1">Balance</h6>
                            <h4 class="fw-bold mb-0 text-primary">{{ number_format($user->wallet_balance, 2) }} ৳</h4>
                        </div>
                        <div class="col-3 border-end">
                            <h6 class="text-muted mb-1">Total Purchase</h6>
                            <h4 class="fw-bold mb-0">{{ number_format($totalPurchase, 2) }} ৳</h4>
                        </div>
                        <div class="col-3 border-end">
                            <h6 class="text-muted mb-1">Total Pay</h6>
                            <h4 class="fw-bold mb-0 text-success">{{ number_format($totalPay, 2) }} ৳</h4>
                        </div>
                        <div class="col-3">
                            <h6 class="text-muted mb-1">Due</h6>
                            <h4 class="fw-bold mb-0 text-danger">{{ number_format($totalPurchase - $totalPay, 2) }} ৳</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Profile Card -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="position-relative d-inline-block mb-3">
                        <img src="{{ $user->image ? url('upload/profile_pic', $user->image) : url('frontend/images/profile.png') }}"
                            class="rounded-circle shadow" style="width: 120px; height: 120px; object-fit: cover;">
                        <span class="position-absolute bottom-0 end-0 badge rounded-circle p-2 {{ $user->is_varified ? 'bg-success' : 'bg-secondary' }}">
                            <i class="fas {{ $user->is_varified ? 'fa-check' : 'fa-times' }} text-white"></i>
                        </span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
                    <p class="text-muted mb-3">{{ $user->phone }}</p>
                    <div class="d-flex justify-content-center gap-2">
                        <span class="badge {{ $user->status == 1 ? 'bg-success' : 'bg-danger' }}">User: {{ $user->status_label }}</span>
                        <span class="badge {{ $user->is_hold ? 'bg-warning' : 'bg-success' }}">Wallet: {{ $user->is_hold ? 'Hold' : 'Active' }}</span>
                    </div>
                </div>
            </div>

            <!-- NID Info -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">Wallet Documents</div>
                <div class="card-body">
                    @if($user->n_id_front)
                    <div class="row g-2 mb-3">
                        <div class="col-6"><img src="{{ url('upload/images', $user->n_id_front) }}" class="img-fluid rounded border"></div>
                        <div class="col-6"><img src="{{ url('upload/images', $user->n_id_back) }}" class="img-fluid rounded border"></div>
                    </div>
                    @else
                    <p class="text-muted small text-center">No Documents Uploaded</p>
                    @endif

                    <button wire:click="toggleHold" class="btn {{ $user->is_hold ? 'btn-success' : 'btn-warning' }} w-100">
                        {{ $user->is_hold ? 'Re-Activate Wallet' : 'Hold Wallet' }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Content -->
        <div class="col-md-8">
            <!-- Package Management -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold">Package History</h5>
                    @if(($totalPurchase - $totalPay) == 0)
                    <button data-bs-toggle="modal" data-bs-target="#package_modal" class="btn btn-sm btn-primary">Change Package</button>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle">
                            <thead class="table-light text-muted small">
                                <tr>
                                    <th>Package</th>
                                    <th>Valid From/To</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($packages as $pkg)
                                <tr>
                                    <td><strong>{{ $pkg->package->amount }} ৳</strong><br><small>{{ $pkg->package->validate }} Days</small></td>
                                    <td>
                                        <small>{{ $pkg->valid_from ? date('d-M-y', strtotime($pkg->valid_from)) : '---' }}</small><br>
                                        <small class="{{ Carbon\Carbon::now() > $pkg->valid_to ? 'text-danger fw-bold' : '' }}">
                                            {{ $pkg->valid_to ? date('d-M-y', strtotime($pkg->valid_to)) : '---' }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($pkg->status == 1)
                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-secondary">Pending</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if($pkg->status == 0)
                                        <button wire:click="approvePackage({{ $pkg->id }})" class="btn btn-xs btn-success py-0">Approve</button>
                                        <button wire:click="confirmDeletePackage({{ $pkg->id }})" class="btn btn-xs btn-danger py-0">Delete</button>
                                        @elseif($user->is_expired == 1)
                                        <button wire:click="openExtendModal({{ $pkg->id }}, '{{ $pkg->valid_to }}')" class="btn btn-xs btn-info py-0 text-white">Extend</button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- History Tables -->
            <div class="row">
                <!-- Purchase Table -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white fw-bold">Recent Purchases</div>
                        <div class="card-body p-0">
                            <table class="table table-sm mb-0">
                                <tbody class="small">
                                    @foreach($purchases as $pur)
                                    <tr>
                                        <td>#{{ $pur->order->invoice ?? 'N/A' }}</td>
                                        <td>{{ date('d-M', strtotime($pur->created_at)) }}</td>
                                        <td class="text-end fw-bold">{{ $pur->amount }} ৳</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Payment Table -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Payment History</span>
                            <button data-bs-toggle="modal" data-bs-target="#pay_modal" class="btn btn-xs btn-outline-primary py-0">Add Pay</button>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-sm mb-0">
                                <tbody class="small">
                                    @foreach($payments as $pay)
                                    <tr>
                                        <td>{{ date('d-M-y', strtotime($pay->date)) }}</td>
                                        <td class="text-end fw-bold text-success">{{ $pay->amount }} ৳</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODALS (Package, Extend, Payment, Delete) -->
    <!-- Use standard Bootstrap Modals with wire:ignore.self -->
    <div wire:ignore.self class="modal fade" id="package_modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Assign New Package</h5>
                </div>
                <div class="modal-body">
                    <select wire:model="selected_package_id" class="form-select">
                        <option value="">Select Package</option>
                        @foreach($availablePacks as $p)
                        <option value="{{ $p->id }}">{{ $p->amount }} - {{ $p->validate }} Days</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button wire:click="changePackage" class="btn btn-primary">Assign</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="pay_modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Payment</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Date</label>
                        <input type="date" wire:model="payment_date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Amount</label>
                        <input type="number" wire:model="payment_amount" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click="addPayment" class="btn btn-success">Save Payment</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Delete Modal -->
    <div wire:ignore.self class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h6>Are you sure?</h6>
                    <button wire:click="deletePackage" class="btn btn-danger btn-sm">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>