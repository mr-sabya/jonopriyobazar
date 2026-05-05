<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Header -->
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-primary">Cancel Reason List</h5>
                    <button wire:click="create" class="btn btn-primary shadow-sm">
                        <i class="fas fa-plus me-1"></i> Add New Reason
                    </button>
                </div>

                <!-- Filters -->
                <div class="card-body border-bottom">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" wire:model.live.debounce.300ms="search" class="form-control bg-light border-start-0 ps-0 shadow-none" placeholder="Search reason...">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4" width="10%">#</th>
                                    <th>Reason Name</th>
                                    <th class="text-end pe-4" width="20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reasons as $index => $reason)
                                <tr wire:key="reason-{{ $reason->id }}">
                                    <td class="ps-4">{{ $reasons->firstItem() + $index }}</td>
                                    <td class="fw-bold">{{ $reason->name }}</td>
                                    <td class="text-end pe-4">
                                        <button wire:click="edit({{ $reason->id }})" class="btn btn-sm btn-outline-success rounded-circle me-1">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="confirmDelete({{ $reason->id }})" class="btn btn-sm btn-outline-danger rounded-circle">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">No reasons found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-3 border-top">
                        {{ $reasons->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div wire:ignore.self class="modal fade" id="reasonModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="fw-bold">{{ $isEditMode ? 'Edit' : 'Add New' }} Cancel Reason</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}">
                    <div class="modal-body py-4">
                        <div class="form-group mb-0">
                            <label class="form-label fw-bold small">Reason Name</label>
                            <input type="text" wire:model="name" class="form-control shadow-none @error('name') is-invalid @enderror" placeholder="Enter cancel reason">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">
                            <span wire:loading wire:target="{{ $isEditMode ? 'update' : 'store' }}" class="spinner-border spinner-border-sm me-1"></span>
                            {{ $isEditMode ? 'Update Reason' : 'Save Reason' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div wire:ignore.self class="modal fade" id="confirmDeleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow">
                <div class="modal-body text-center py-4">
                    <div class="text-danger mb-3">
                        <i class="fas fa-exclamation-triangle fa-3x"></i>
                    </div>
                    <h5 class="fw-bold">Are you sure?</h5>
                    <p class="text-muted small">You want to remove this cancel reason?</p>
                    <div class="d-flex justify-content-center gap-2 mt-4">
                        <button type="button" class="btn btn-light px-3" data-bs-dismiss="modal">No</button>
                        <button type="button" wire:click="delete" class="btn btn-danger px-3">
                            <span wire:loading wire:target="delete" class="spinner-border spinner-border-sm me-1"></span>
                            Yes, Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        // Modal Handlers
        Livewire.on('open-modal', (event) => {
            var myModal = new bootstrap.Modal(document.getElementById(event.id));
            myModal.show();
        });

        Livewire.on('close-modal', (event) => {
            var modalEl = document.getElementById(event.id);
            var modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
        });

        // SweetAlert Feedback
        Livewire.on('swal', (event) => {
            swal({
                title: event[0].title,
                text: event[0].text,
                icon: event[0].icon,
                button: "Ok",
            });
        });
    });
</script>
@endpush