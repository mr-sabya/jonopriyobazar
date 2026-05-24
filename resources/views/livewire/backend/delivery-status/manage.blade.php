<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Delivery Status List</h5>
                    <div class="d-flex gap-2">
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control form-control-sm" placeholder="Search status...">
                        <button wire:click="create" class="btn btn-success btn-sm text-nowrap">
                            <i class="ri-add-line"></i> Add New
                        </button>
                    </div>
                </div>

                <div class="card-body p-0">
                    @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">#</th>
                                    <th>Status Name</th>
                                    <th>Slug</th>
                                    <th class="text-end pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($statuses as $index => $status)
                                <tr>
                                    <td class="ps-3 text-muted">{{ $statuses->firstItem() + $index }}</td>
                                    <td class="fw-bold">{{ $status->name }}</td>
                                    <td><code class="small">{{ $status->slug }}</code></td>
                                    <td class="text-end pe-3">
                                        <button wire:click="edit({{ $status->id }})" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="ri-pencil-line"></i> Edit
                                        </button>
                                        <button wire:click="delete({{ $status->id }})"
                                            wire:confirm="Are you sure you want to delete this status?"
                                            class="btn btn-sm btn-outline-danger">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">No delivery statuses found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white py-3">
                    {{ $statuses->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <div wire:ignore.self class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header {{ $isEditMode ? 'bg-primary' : 'bg-success' }} text-white">
                    <h5 class="modal-title">{{ $isEditMode ? 'Update Status' : 'Add New Status' }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status Name</label>
                            <input type="text" wire:model.live="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Processing">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Slug</label>
                            <input type="text" wire:model="slug" class="form-control @error('slug') is-invalid @enderror" placeholder="processing">
                            <small class="text-muted">Auto-generated from name.</small>
                            @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn {{ $isEditMode ? 'btn-primary' : 'btn-success' }} px-4">
                            <span wire:loading.remove wire:target="save">Save Changes</span>
                            <span wire:loading wire:target="save">Processing...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
        window.addEventListener('open-modal', () => statusModal.show());
        window.addEventListener('close-modal', () => statusModal.hide());
    </script>
    @endpush
</div>