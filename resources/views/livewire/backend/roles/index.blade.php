<div>
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary fw-bold">Role Management</h5>
                    <div class="d-flex gap-2">
                        <input type="text" wire:model.debounce.300ms="search" class="form-control form-control-sm" placeholder="Search roles...">
                        @can('admin.roles.create')
                        <button wire:click="create" class="btn btn-sm btn-primary px-3 text-nowrap">+ New Role</button>
                        @endcan
                    </div>
                </div>
                <div class="card-body p-0">
                    @if (session()->has('success'))
                    <div class="alert alert-success m-3 py-2 small">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="small text-muted">
                                    <th class="ps-3">#</th>
                                    <th>ROLE NAME</th>
                                    <th style="width: 70%;">PERMISSIONS</th>
                                    <th class="text-end pe-3">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td class="ps-3">{{ $loop->iteration }}</td>
                                    <td class="fw-bold">{{ $role->name }}</td>
                                    <td>
                                        @foreach($role->permissions as $perm)
                                        <span class="badge bg-info-soft text-info border border-info mb-1" style="font-size: 10px;">{{ $perm->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="text-end pe-3">
                                        @can('admin.roles.edit')
                                        <button wire:click="edit({{ $role->id }})" class="btn btn-outline-primary py-0">
                                            <i class="ri-edit-2-line"></i>
                                        </button>
                                        @endcan
                                        @can('admin.roles.destroy')
                                        <button wire:click="confirmDelete({{ $role->id }})" class="btn btn-outline-danger py-0">
                                            <i class="ri-delete-bin-5-line"></i>
                                        </button>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3">{{ $roles->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- CREATE/EDIT MODAL -->
    <div wire:ignore.self class="modal fade" id="roleModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}" class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">{{ $isEditMode ? 'Edit Role' : 'Create New Role' }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Role Name</label>
                        <input type="text" wire:model.defer="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Super Admin">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <label class="fw-bold">Permissions</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="allCheck"
                                wire:click="toggleAll"
                                {{ count($selectedPermissions) === $total_permissions ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="allCheck">Select All</label>
                        </div>
                    </div>
                    <hr class="mt-0">

                    @foreach ($permission_groups as $group)
                    <div class="row mb-3 border-bottom pb-2">
                        <div class="col-md-3">
                            <div class="form-check">
                                @php
                                $groupPermNames = App\Models\Admin::getpermissionsByGroupName($group->name)->pluck('name')->toArray();
                                $isGroupChecked = count(array_intersect($groupPermNames, $selectedPermissions)) === count($groupPermNames);
                                @endphp
                                <input class="form-check-input" type="checkbox" id="group-{{ $loop->index }}"
                                    wire:click="toggleGroup('{{ $group->name }}')"
                                    {{ $isGroupChecked ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold text-primary" for="group-{{ $loop->index }}">
                                    {{ $group->name }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                @foreach (App\Models\Admin::getpermissionsByGroupName($group->name) as $permission)
                                <div class="col-md-4 mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            wire:model="selectedPermissions"
                                            value="{{ $permission->name }}"
                                            id="perm-{{ $permission->id }}">
                                        <label class="form-check-label small" for="perm-{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary px-4">
                        <span wire:loading wire:target="store, update" class="spinner-border spinner-border-sm me-1"></span>
                        {{ $isEditMode ? 'Update Role' : 'Create Role' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- DELETE CONFIRMATION MODAL -->
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-body text-center py-4">
                    <div class="text-danger mb-3" style="font-size: 40px;"><i class="bi bi-exclamation-circle"></i></div>
                    <h6>Delete this Role?</h6>
                    <p class="small text-muted">This action is permanent and cannot be undone.</p>
                    <div class="d-flex justify-content-center gap-2 mt-4">
                        <button type="button" class="btn btn-sm btn-light px-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" wire:click="destroy" class="btn btn-sm btn-danger px-3">Confirm Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const roleModal = new bootstrap.Modal(document.getElementById('roleModal'));
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

        window.addEventListener('show-role-modal', () => roleModal.show());
        window.addEventListener('hide-role-modal', () => roleModal.hide());
        window.addEventListener('show-delete-modal', () => deleteModal.show());
        window.addEventListener('hide-delete-modal', () => deleteModal.hide());
    </script>
    @endpush

    <style>
        .bg-info-soft {
            background-color: #e1f5fe;
        }

        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
</div>