<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Header -->
                <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                    <h5 class="m-0 fw-bold text-primary">Category Management</h5>
                    @can('category.create')
                        <button wire:click="openModal" class="btn btn-primary btn-sm shadow-sm">
                            <i class="fas fa-plus me-1"></i> Add Category
                        </button>
                    @endcan
                </div>

                <div class="card-body">
                    <!-- Filters -->
                    <div class="row g-3 mb-4 mt-1">
                        <div class="col-md-1">
                            <select wire:model="perPage" class="form-select form-select-sm">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <div class="col-md-7"></div>
                        <div class="col-md-4 text-end">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" wire:model.debounce.300ms="search" class="form-control border-start-0 ps-0" placeholder="Search categories...">
                            </div>
                        </div>
                    </div>

                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Custom Datatable with Collapse -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="categoryTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0" width="5%">#</th>
                                    <th class="border-0" width="8%">Icon</th>
                                    <th class="border-0" style="cursor:pointer;" wire:click="sortBy('name')">
                                        Category Name
                                        @if($sortField == 'name') <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ms-1"></i> @endif
                                    </th>
                                    <th class="border-0">Slug</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $index => $category)
                                    <!-- Parent Row -->
                                    <tr class="fw-bold align-middle border">
                                        <td>{{ $categories->firstItem() + $index }}</td>
                                        <td>
                                            <img src="{{ $category->icon ? asset('upload/images/' . $category->icon) : asset('backend/images/default.png') }}"
                                                class="rounded border shadow-sm" width="35">
                                        </td>
                                        <td>
                                            <!-- Toggle Button -->
                                            <button 
                                                class="btn btn-link btn-sm text-decoration-none fw-bold p-0 me-2 text-primary shadow-none" 
                                                type="button" 
                                                data-bs-toggle="collapse" 
                                                data-bs-target=".parent-{{ $category->id }}" 
                                                aria-expanded="false">
                                                <i class="fas fa-chevron-right chevron-icon me-1 transition-all"></i>
                                                {{ $category->name }}
                                            </button>
                                        </td>
                                        <td class="text-muted small">{{ $category->slug }}</td>
                                        <td>
                                            @if($category->is_home) 
                                                <span class="badge bg-success-soft text-success border border-success px-2 rounded-pill">Home</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group shadow-sm border rounded">
                                                <button wire:click="edit({{ $category->id }})" class="btn btn-sm btn-white border-0"><i class="fas fa-edit text-primary"></i></button>
                                                <button onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="delete({{ $category->id }})" class="btn btn-sm btn-white border-0"><i class="fas fa-trash text-danger"></i></button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Subcategories (Collapsed by Default) -->
                                    @foreach($category->sub as $subIndex => $sub)
                                        <tr class="collapse parent-{{ $category->id }} bg-light border-0">
                                            <td class="ps-4 text-muted small">{{ $categories->firstItem() + $index }}.{{ $subIndex + 1 }}</td>
                                            <td class="ps-4">
                                                <img src="{{ $sub->icon ? asset('upload/images/' . $sub->icon) : asset('backend/images/default.png') }}"
                                                    class="rounded border" width="30">
                                            </td>
                                            <td class="ps-5 text-muted">
                                                <i class="fas fa-level-up-alt fa-rotate-90 text-muted opacity-50 me-2"></i>
                                                {{ $sub->name }}
                                            </td>
                                            <td class="text-muted small">{{ $sub->slug }}</td>
                                            <td></td>
                                            <td class="text-end">
                                                <div class="btn-group border rounded bg-white">
                                                    <button wire:click="edit({{ $sub->id }})" class="btn btn-sm btn-white border-0"><i class="fas fa-edit text-muted"></i></button>
                                                    <button onclick="confirm('Delete sub-category?') || event.stopImmediatePropagation()" wire:click="delete({{ $sub->id }})" class="btn btn-sm btn-white border-0"><i class="fas fa-trash text-muted"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">No categories found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Manage Modal -->
    <div wire:ignore.self class="modal fade" id="manageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form wire:submit.prevent="save">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title fw-bold text-primary">{{ $isEditMode ? 'Update' : 'Add' }} Category</h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Category Name</label>
                                <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Art Work">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Slug</label>
                                <input type="text" wire:model="slug" class="form-control @error('slug') is-invalid @enderror">
                                @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Parent Category</label>
                                <select wire:model="p_id" class="form-select @error('p_id') is-invalid @enderror">
                                    <option value="0">None (Top Level)</option>
                                    @foreach($parent_categories as $parent)
                                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                        @foreach($parent->sub as $subParent)
                                            <option value="{{ $subParent->id }}">-- {{ $subParent->name }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 d-flex align-items-center pt-4">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input shadow-none" type="checkbox" wire:model="is_home" id="isHomeSwitch">
                                    <label class="form-check-label fw-bold text-muted small" for="isHomeSwitch">Display on Home Page</label>
                                </div>
                            </div>

                            <div class="col-md-6 mt-4">
                                <label class="form-label fw-bold small text-muted">Icon (40x40)</label>
                                <input type="file" wire:model="icon" class="form-control">
                                @if($icon) <img src="{{ $icon->temporaryUrl() }}" class="mt-2 rounded border shadow-sm" width="50">
                                @elseif($oldIcon) <img src="{{ asset('upload/images/' . $oldIcon) }}" class="mt-2 rounded border shadow-sm" width="50"> @endif
                            </div>

                            <div class="col-md-6 mt-4">
                                <label class="form-label fw-bold small text-muted">Cover Image</label>
                                <input type="file" wire:model="image" class="form-control">
                                @if($image) <img src="{{ $image->temporaryUrl() }}" class="mt-2 rounded border shadow-sm" width="80">
                                @elseif($oldImage) <img src="{{ asset('upload/images/' . $oldImage) }}" class="mt-2 rounded border shadow-sm" width="80"> @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 bg-light p-3">
                        <button type="button" class="btn btn-white shadow-none me-auto" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm" wire:loading.attr="disabled">
                            <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-1"></span>
                            {{ $isEditMode ? 'Update' : 'Create' }} Category
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('css')
    <style>
        .transition-all { transition: all 0.3s ease; }
        /* Rotate chevron when clicked */
        [aria-expanded="true"] .chevron-icon {
            transform: rotate(90deg);
        }
        .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
        .bg-light-50 { background-color: #f8f9fa; }
        .shadow-none-hover:hover { box-shadow: none !important; }
        #categoryTable tr.collapse.show {
            display: table-row; /* Ensures the row shows correctly as a table row */
        }
    </style>
    @endpush

    @push('scripts')
        <script>
            window.addEventListener('openModal', event => {
                var myModal = new bootstrap.Modal(document.getElementById('manageModal'));
                myModal.show();
            });
            window.addEventListener('closeModal', event => {
                bootstrap.Modal.getInstance(document.getElementById('manageModal')).hide();
            });
        </script>
    @endpush
</div>