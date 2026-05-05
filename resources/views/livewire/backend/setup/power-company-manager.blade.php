<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Header -->
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-primary">Power Companies</h5>
                    <button wire:click="create" class="btn btn-primary shadow-sm">
                        <i class="fas fa-plus me-1"></i> Add Company
                    </button>
                </div>

                <!-- Filters -->
                <div class="card-body border-bottom bg-light-soft">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" wire:model.live.debounce.300ms="search" class="form-control border-start-0 ps-0 shadow-none" placeholder="Search by name...">
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
                                    <th class="ps-4">#</th>
                                    <th>Logo</th>
                                    <th>Company Name</th>
                                    <th>Type</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($companies as $index => $item)
                                <tr wire:key="power-{{ $item->id }}">
                                    <td class="ps-4">{{ $companies->firstItem() + $index }}</td>
                                    <td>
                                        @if($item->logo)
                                        <img src="{{ asset('upload/images/'.$item->logo) }}" class="rounded border shadow-sm" width="50" height="35" style="object-fit: contain;">
                                        @else
                                        <span class="text-muted small">No Image</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-dark">{{ $item->name }}</td>
                                    <td><span class="badge bg-info-soft text-info">{{ $item->type }}</span></td>
                                    <td class="text-end pe-4">
                                        <button wire:click="edit({{ $item->id }})" class="btn btn-sm btn-outline-success rounded-circle me-1">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="confirmDelete({{ $item->id }})" class="btn btn-sm btn-outline-danger rounded-circle">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">No companies found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-3 border-top">
                        {{ $companies->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div wire:ignore.self class="modal fade" id="powerModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="fw-bold">{{ $isEditMode ? 'Edit' : 'Add' }} Power Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}">
                    <div class="modal-body py-3">
                        <!-- Preview Image -->
                        <div class="text-center mb-3">
                            @if ($logo)
                            <img src="{{ $logo->temporaryUrl() }}" class="rounded border shadow-sm" width="100">
                            @elseif($oldLogo)
                            <img src="{{ asset('upload/images/'.$oldLogo) }}" class="rounded border shadow-sm" width="100">
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Company Name</label>
                            <input type="text" wire:model="name" class="form-control shadow-none @error('name') is-invalid @enderror">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Type</label>
                            <input type="text" wire:model="type" class="form-control shadow-none @error('type') is-invalid @enderror" placeholder="e.g. Prepaid / Postpaid">
                            @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-0">
                            <label class="form-label small fw-bold">Logo</label>
                            <input type="file" wire:model="logo" class="form-control shadow-none @error('logo') is-invalid @enderror">
                            <div wire:loading wire:target="logo" class="text-primary small mt-1">Uploading preview...</div>
                            @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm" wire:loading.attr="disabled">
                            <span wire:loading wire:target="{{ $isEditMode ? 'update' : 'store' }}" class="spinner-border spinner-border-sm me-1"></span>
                            {{ $isEditMode ? 'Update Changes' : 'Save Company' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow">
                <div class="modal-body text-center py-4">
                    <i class="fas fa-exclamation-circle fa-3x text-danger mb-3"></i>
                    <h5 class="fw-bold">Delete Record?</h5>
                    <p class="text-muted small">This action cannot be undone.</p>
                    <div class="d-flex justify-content-center gap-2 mt-4">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
                        <button type="button" wire:click="delete" class="btn btn-danger px-3">Yes, Delete</button>
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