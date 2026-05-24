<div>
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <!-- Header -->
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Team Members</h5>
                    <div class="d-flex gap-2">
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control form-control-sm" placeholder="Search members...">
                        <button wire:click="create" class="btn btn-primary btn-sm text-nowrap">
                            <i class="ri-user-add-line"></i> Add Member
                        </button>
                    </div>
                </div>

                <!-- Table Content -->
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
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th class="text-end pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($teams as $index => $team)
                                <tr>
                                    <td class="ps-3 text-muted">{{ $teams->firstItem() + $index }}</td>
                                    <td>
                                        <img src="{{ asset('upload/images/'.$team->image) }}" class="rounded-circle border" width="50" height="50" style="object-fit: cover;">
                                    </td>
                                    <td class="fw-bold">{{ $team->name }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $team->designation }}</span></td>
                                    <td class="text-end pe-3">
                                        <button wire:click="edit({{ $team->id }})" class="btn btn-sm btn-outline-success">
                                            <i class="ri-pencil-line"></i>
                                        </button>
                                        <button wire:click="delete({{ $team->id }})" wire:confirm="Are you sure you want to remove this team member?" class="btn btn-sm btn-outline-danger">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">No team members found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-white py-3">
                    {{ $teams->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Member Form Modal -->
    <div wire:ignore.self class="modal fade" id="teamModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header {{ $isEditMode ? 'bg-success' : 'bg-primary' }} p-3">
                    <h5 class="modal-title text-white">{{ $isEditMode ? 'Edit Member' : 'Add New Member' }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Full Name</label>
                            <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Designation</label>
                            <input type="text" wire:model="designation" class="form-control @error('designation') is-invalid @enderror">
                            @error('designation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Profile Image</label>
                            <input type="file" wire:model="image" class="form-control @error('image') is-invalid @enderror">
                            <div wire:loading wire:target="image" class="text-primary small mt-1">Processing image...</div>
                            @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

                            <!-- Image Preview -->
                            <div class="mt-3 text-center">
                                @if ($image)
                                <p class="small text-muted mb-1">New Preview:</p>
                                <img src="{{ $image->temporaryUrl() }}" class="rounded-circle border" width="100" height="100" style="object-fit: cover;">
                                @elseif ($old_image)
                                <p class="small text-muted mb-1">Current Photo:</p>
                                <img src="{{ asset('upload/images/'.$old_image) }}" class="rounded-circle border" width="100" height="100" style="object-fit: cover;">
                                @endif
                            </div>
                            <small class="text-muted d-block mt-2">Recommended: 255px X 255px (Max 2MB)</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn {{ $isEditMode ? 'btn-success' : 'btn-primary' }} px-4">
                            <span wire:loading.remove wire:target="save">Save Member</span>
                            <span wire:loading wire:target="save">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const tModal = new bootstrap.Modal(document.getElementById('teamModal'));
        window.addEventListener('open-modal', () => tModal.show());
        window.addEventListener('close-modal', () => tModal.hide());
    </script>
    @endpush
</div>