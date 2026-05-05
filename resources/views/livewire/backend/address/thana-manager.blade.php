<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold text-primary">Thana Management</h5>
                    <button class="btn btn-primary shadow-sm" wire:click="resetInput" data-bs-toggle="modal" data-bs-target="#thanaModal">
                        <i class="fas fa-plus me-2"></i>Add New Thana
                    </button>
                </div>
                <div class="card-body">
                    <!-- Search Controls -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" wire:model.live.debounce.300ms="search" class="form-control border-start-0 ps-0 shadow-none" placeholder="Search thana or district...">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Thana Name</th>
                                    <th>District</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($thanas as $index => $thana)
                                <tr>
                                    <td>{{ $thanas->firstItem() + $index }}</td>
                                    <td class="fw-bold">{{ $thana->name }}</td>
                                    <td>
                                        <span class="badge bg-primary-soft text-primary px-3 rounded-pill">
                                            {{ $thana->district->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <button wire:click="edit({{ $thana->id }})" class="btn btn-sm btn-outline-success rounded-circle me-1" data-bs-toggle="modal" data-bs-target="#thanaModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button
                                            onclick="confirm('Are you sure you want to delete this?') || event.stopImmediatePropagation()"
                                            wire:click="delete({{ $thana->id }})"
                                            class="btn btn-sm btn-outline-danger rounded-circle">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">No thanas found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $thanas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="thanaModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="fw-bold mb-0">{{ $isEditMode ? 'Edit Thana' : 'Add New Thana' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}">
                    <div class="modal-body py-4">
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-2">Thana Name</label>
                            <input type="text" wire:model="name" class="form-control shadow-none @error('name') is-invalid @enderror" placeholder="Enter thana name">
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-2">District</label>
                            <select wire:model="district_id" class="form-select shadow-none @error('district_id') is-invalid @enderror">
                                <option value="">-- select district --</option>
                                @foreach($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                            @error('district_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">
                            <span wire:loading wire:target="{{ $isEditMode ? 'update' : 'store' }}" class="spinner-border spinner-border-sm me-2"></span>
                            {{ $isEditMode ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .bg-primary-soft {
            background-color: rgba(13, 110, 253, 0.1);
        }
    </style>
</div>

@script
<script>
    $wire.on('close-modal', () => {
        const modal = document.getElementById('thanaModal');
        const modalInstance = bootstrap.Modal.getInstance(modalElement);

        if (modalInstance) {
            // 1. Remove focus from whatever is currently focused (like the close button)
            if (document.activeElement instanceof HTMLElement) {
                document.activeElement.blur();
            }

            // 2. Hide the modal via Bootstrap
            modalInstance.hide();

            // 3. Forced Cleanup: After the fade transition, ensure aria-hidden is removed
            // so the next time Livewire renders, it doesn't "freeze" the hidden state.
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