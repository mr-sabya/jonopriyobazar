<div>
    <div class="row g-4">
        <!-- Form Section (Same as previous) -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 text-white">{{ $isEditMode ? 'Update Permission' : 'Bulk Add Permissions' }}</h6>
                    @if($isEditMode)
                    <button wire:click="resetBulkFields" class="btn btn-sm btn-outline-light">Switch to Bulk</button>
                    @endif
                </div>
                <div class="card-body">
                    @if($isEditMode)
                    <form wire:submit.prevent="update">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Permission Name</label>
                            <input type="text" wire:model.defer="edit_name" class="form-control @error('edit_name') is-invalid @enderror">
                            @error('edit_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Group Name</label>
                            <input type="text" wire:model.defer="edit_group_name" class="form-control @error('edit_group_name') is-invalid @enderror">
                            @error('edit_group_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Update Record</button>
                            <button type="button" wire:click="resetBulkFields" class="btn btn-light">Cancel</button>
                        </div>
                    </form>
                    @else
                    <form wire:submit.prevent="storeBulk">
                        <table class="table table-sm align-middle">
                            <thead>
                                <tr class="small text-muted">
                                    <th>NAME</th>
                                    <th>GROUP</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inputs as $index => $input)
                                <tr wire:key="input-{{ $index }}">
                                    <td>
                                        <input type="text" wire:model.defer="inputs.{{ $index }}.name"
                                            class="form-control @error('inputs.'.$index.'.name') is-invalid @enderror">
                                    </td>
                                    <td>
                                        <input type="text" wire:model.defer="inputs.{{ $index }}.group_name"
                                            class="form-control @error('inputs.'.$index.'.group_name') is-invalid @enderror">
                                    </td>
                                    <td>
                                        @if(count($inputs) > 1)
                                        <button type="button" wire:click="removeRow({{ $index }})" class="btn btn-link text-danger p-0">
                                            <i class="bi bi-trash"></i> &times;
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-between">
                            <button type="button" wire:click="addRow" class="btn btn-sm btn-outline-secondary">+ Row</button>
                            <button type="submit" class="btn btn-sm btn-success px-4">Save All</button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm text-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="row align-items-center">
                        <div class="col">Permission List</div>
                        <div class="col">
                            <input type="text" wire:model.live.debounce.300ms="search" class="form-control  form-control-sm" placeholder="Search...">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if (session()->has('success'))
                    <div class="alert alert-success mx-3 mt-2 small py-2">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light border-top">
                                <tr>
                                    <th class="ps-3">#</th>
                                    <th>Name</th>
                                    <th>Group</th>
                                    <th class="text-end pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permissions as $permission)
                                <tr>
                                    <td class="ps-3 text-muted small">{{ $loop->iteration }}</td>
                                    <td><code>{{ $permission->name }}</code></td>
                                    <td><span class="badge bg-light text-dark border">{{ $permission->group_name }}</span></td>
                                    <td class="text-end pe-3">
                                        @can('admin.permissions.edit')
                                        <button wire:click="edit({{ $permission->id }})" class="btn btn-outline-primary py-0">
                                            <i class="ri-edit-2-line"></i>
                                        </button>
                                        @endcan

                                        @can('admin.permissions.destroy')
                                        <!-- This triggers the confirmDelete logic -->
                                        <button wire:click="confirmDelete({{ $permission->id }})" class="btn btn-outline-danger py-0">
                                            <i class="ri-delete-bin-5-line"></i>
                                        </button>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3">
                        {{ $permissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Delete Modal -->
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fs-6 fw-bold" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    Are you sure you want to delete this permission? This action cannot be undone.
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-sm btn-light px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" wire:click="destroy" class="btn btn-sm btn-danger px-3">
                        <span wire:loading wire:target="destroy" class="spinner-border spinner-border-sm me-1"></span>
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Use standard Bootstrap 5 JS to toggle the modal
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

        window.addEventListener('show-delete-modal', event => {
            deleteModal.show();
        });

        window.addEventListener('hide-delete-modal', event => {
            deleteModal.hide();
        });
    </script>
    @endpush
</div>