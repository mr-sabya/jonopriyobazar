<div class="container-fluid py-4">
    <!-- Filter Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <!-- Search -->
                <div class="col-md-4">
                    <label class="small fw-bold text-muted">Search User</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control border-start-0 ps-0 shadow-none" placeholder="Name or phone...">
                    </div>
                </div>

                <!-- Date From -->
                <div class="col-md-3">
                    <label class="small fw-bold text-muted">From Date</label>
                    <input type="date" wire:model.live="dateFrom" class="form-control shadow-none">
                </div>

                <!-- Date To -->
                <div class="col-md-3">
                    <label class="small fw-bold text-muted">To Date</label>
                    <input type="date" wire:model.live="dateTo" class="form-control shadow-none">
                </div>

                <!-- Reset -->
                <div class="col-md-2 d-flex align-items-end">
                    <button wire:click="resetFilters" class="btn btn-light w-100 border shadow-none">
                        <i class="fas fa-undo me-1"></i> Clear
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-primary">Pending Wallet Requests</h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Customer Info</th>
                            <th>Request Date</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $index => $user)
                        <tr wire:key="req-{{ $user->id }}">
                            <td class="ps-4">{{ $requests->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" class="rounded-circle me-2" width="35">
                                    <div>
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                        <div class="small text-muted">{{ $user->phone }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border fw-normal px-2 py-1">
                                    <i class="far fa-calendar-alt me-1 text-muted"></i>
                                    {{ $user->request_date ? date('d-M-Y', strtotime($user->request_date)) : 'N/A' }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <button wire:click="showRequest({{ $user->id }})" class="btn btn-sm btn-primary shadow-sm px-3">
                                    <i class="fas fa-id-card me-1"></i> Verify
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-3x mb-3 opacity-25"></i>
                                <p>No wallet requests found for selected filters.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-top">
                {{ $requests->links() }}
            </div>
        </div>
    </div>

    <!-- Modal (Keep the same logic as before) -->
    <div wire:ignore.self class="modal fade" id="requestDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold">Request Verification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                @if($selectedUser)
                <div class="modal-body py-4">
                    <div class="row">
                        <div class="col-md-12 text-center mb-4">
                            <img src="{{ $selectedUser->image ? url('upload/profile_pic', $selectedUser->image) : 'https://ui-avatars.com/api/?name='.urlencode($selectedUser->name) }}"
                                class="rounded-circle shadow-sm border mb-2" width="100" height="100">
                            <h4 class="fw-bold mb-0">{{ $selectedUser->name }}</h4>
                            <p class="text-muted">{{ $selectedUser->phone }}</p>
                        </div>

                        <div class="col-md-6 mb-3 text-center">
                            <label class="small fw-bold text-muted mb-2 d-block">NID Front</label>
                            <div class="border rounded p-1 bg-light">
                                <img src="{{ $selectedUser->n_id_front ? url('upload/images', $selectedUser->n_id_front) : 'https://placehold.co/400x250?text=No+Image' }}" class="img-fluid rounded">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 text-center">
                            <label class="small fw-bold text-muted mb-2 d-block">NID Back</label>
                            <div class="border rounded p-1 bg-light">
                                <img src="{{ $selectedUser->n_id_back ? url('upload/images', $selectedUser->n_id_back) : 'https://placehold.co/400x250?text=No+Image' }}" class="img-fluid rounded">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button wire:click="approve" wire:loading.attr="disabled" class="btn btn-success px-5">
                        <span wire:loading wire:target="approve" class="spinner-border spinner-border-sm me-2"></span>
                        Approve Wallet
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        // Modal Events
        Livewire.on('open-modal', (event) => {
            var myModal = new bootstrap.Modal(document.getElementById(event.id));
            myModal.show();
        });

        Livewire.on('close-modal', (event) => {
            var modalEl = document.getElementById(event.id);
            var modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
        });

        // Feedback
        Livewire.on('swal', (event) => {
            swal({
                title: event[0].title,
                text: event[0].text,
                icon: event[0].icon,
                button: "OK",
            });
        });
    });
</script>
@endpush