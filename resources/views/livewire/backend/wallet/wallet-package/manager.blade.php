<div class="container-fluid">
    <div class="row">
        <!-- Form Side -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary">
                        {{ $isEditMode ? 'Edit Package' : 'Add New Package' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Amount (৳)</label>
                            <input type="number" step="0.01" wire:model="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="Enter amount">
                            @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Validity (Days)</label>
                            <input type="number" wire:model="validate" class="form-control @error('validate') is-invalid @enderror" placeholder="Enter days">
                            @error('validate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn {{ $isEditMode ? 'btn-success' : 'btn-primary' }}">
                                <span wire:loading wire:target="{{ $isEditMode ? 'update' : 'store' }}" class="spinner-border spinner-border-sm me-1"></span>
                                {{ $isEditMode ? 'Update Package' : 'Create Package' }}
                            </button>
                            @if($isEditMode)
                            <button type="button" wire:click="resetInput" class="btn btn-light">Cancel</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table Side -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">Package List</h5>
                    <div class="input-group w-50">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control bg-light border-start-0 ps-0 shadow-none" placeholder="Search amount...">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Amount</th>
                                    <th>Validity</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($packages as $index => $package)
                                <tr wire:key="package-{{ $package->id }}">
                                    <td>{{ $packages->firstItem() + $index }}</td>
                                    <td class="fw-bold">{{ number_format($package->amount, 2) }} ৳</td>
                                    <td><span class="badge bg-info-soft text-info px-3">{{ $package->validate }} Days</span></td>
                                    <td class="text-end">
                                        <button wire:click="edit({{ $package->id }})" class="btn btn-sm btn-outline-success rounded-circle me-1">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="confirmDelete({{ $package->id }})" class="btn btn-sm btn-outline-danger rounded-circle">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">No packages found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $packages->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div wire:ignore.self class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="text-danger mb-3">
                        <i class="fas fa-exclamation-circle fa-4x"></i>
                    </div>
                    <h5>Are you sure?</h5>
                    <p class="text-muted">You are about to delete this package. This action cannot be reversed.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" wire:click="delete" class="btn btn-danger px-4">
                        <span wire:loading wire:target="delete" class="spinner-border spinner-border-sm me-1"></span>
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {

        // Show Deletion Modal
        Livewire.on('open-delete-modal', () => {
            var myModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            myModal.show();
        });

        // Hide Deletion Modal
        Livewire.on('close-delete-modal', () => {
            var modalEl = document.getElementById('confirmDeleteModal');
            var modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
        });
    });
</script>
@endpush