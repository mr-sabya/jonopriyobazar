<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold text-primary">District Management</h5>
                    <button class="btn btn-primary shadow-sm" wire:click="resetInput" data-bs-toggle="modal" data-bs-target="#districtModal">
                        <i class="fas fa-plus me-2"></i>Add New District
                    </button>
                </div>
                <div class="card-body">
                    <!-- Search Controls -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" wire:model.live.debounce.300ms="search" class="form-control border-start-0 ps-0 shadow-none" placeholder="Search districts...">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="10%">#</th>
                                    <th>District Name</th>
                                    <th width="20%">Thanas Count</th>
                                    <th width="15%" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($districts as $index => $district)
                                <tr>
                                    <td>{{ $districts->firstItem() + $index }}</td>
                                    <td class="fw-bold">{{ $district->name }}</td>
                                    <td>
                                        <span class="badge bg-info-soft text-info px-3">
                                            {{ $district->thanas_count ?? $district->thanas->count() }} Thanas
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <button wire:click="edit({{ $district->id }})" class="btn btn-sm btn-outline-success rounded-circle me-1" data-bs-toggle="modal" data-bs-target="#districtModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button
                                            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                            wire:click="delete({{ $district->id }})"
                                            class="btn btn-sm btn-outline-danger rounded-circle">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">No districts found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $districts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div wire:ignore.self class="modal fade" id="districtModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0">
                    <h5 class="fw-bold">{{ $isEditMode ? 'Edit District' : 'Add New District' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}">
                    <div class="modal-body py-4">
                        <div class="form-group">
                            <label class="small fw-bold text-muted mb-2">District Name</label>
                            <input type="text" wire:model="name" class="form-control shadow-none @error('name') is-invalid @enderror" placeholder="Enter district name">
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">
                            <span wire:loading wire:target="{{ $isEditMode ? 'update' : 'store' }}" class="spinner-border spinner-border-sm me-2"></span>
                            {{ $isEditMode ? 'Update District' : 'Save District' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .bg-info-soft {
            background-color: rgba(13, 202, 240, 0.1);
        }
    </style>
</div>

@script
<script>
    // Close Modal on Success
    $wire.on('close-modal', () => {
        const modalElement = document.getElementById('districtModal');
        const modalInstance = bootstrap.Modal.getInstance(modalElement);

        if (modalInstance) {

            // Move focus to body (or any safe element)
            document.body.focus();

            // Hide modal
            modalInstance.hide();

            // Cleanup after hidden
            modalElement.addEventListener('hidden.bs.modal', function() {
                modalElement.removeAttribute('aria-hidden');
                modalElement.style.display = 'none';
            }, {
                once: true
            });
        }
    });
</script>
@endscript