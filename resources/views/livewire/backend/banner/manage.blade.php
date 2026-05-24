<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Banner Management</h5>
                    <div class="d-flex gap-2">
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control form-control-sm" placeholder="Search title...">
                        <button wire:click="create" class="btn btn-primary btn-sm text-nowrap">
                            <i class="ri-add-line"></i> Add Banner
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
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Link</th>
                                    <th class="text-end pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($banners as $index => $banner)
                                <tr>
                                    <td class="ps-3 text-muted">{{ $banners->firstItem() + $index }}</td>
                                    <td>
                                        <img src="{{ asset('upload/images/'.$banner->image) }}" class="rounded border" width="100" alt="banner">
                                    </td>
                                    <td class="fw-bold">{{ $banner->title }}</td>
                                    <td class="text-muted small">{{ $banner->link ?: 'No Link' }}</td>
                                    <td class="text-end pe-3">
                                        <button wire:click="edit({{ $banner->id }})" class="btn btn-sm btn-outline-success">
                                            <i class="ri-pencil-line"></i>
                                        </button>
                                        <button wire:click="delete({{ $banner->id }})" wire:confirm="Are you sure you want to delete this banner?" class="btn btn-sm btn-outline-danger">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">No banners found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    {{ $banners->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Banner Form Modal -->
    <div wire:ignore.self class="modal fade" id="bannerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header {{ $isEditMode ? 'bg-success' : 'bg-primary' }} p-3">
                    <h5 class="modal-title text-white">{{ $isEditMode ? 'Edit Banner' : 'Add New Banner' }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Title</label>
                            <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" placeholder="Banner Title">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Banner Link</label>
                            <input type="text" wire:model="link" class="form-control @error('link') is-invalid @enderror" placeholder="https://example.com">
                            @error('link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Banner Image</label>
                            <input type="file" wire:model="image" class="form-control @error('image') is-invalid @enderror">
                            <div wire:loading wire:target="image" class="text-primary small mt-1">Uploading preview...</div>
                            @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

                            <!-- Preview Section -->
                            <div class="mt-3 text-center">
                                @if ($image)
                                <p class="small text-muted mb-1">New Preview:</p>
                                <img src="{{ $image->temporaryUrl() }}" class="img-fluid rounded border" style="max-height: 150px">
                                @elseif ($old_image)
                                <p class="small text-muted mb-1">Current Image:</p>
                                <img src="{{ asset('upload/images/'.$old_image) }}" class="img-fluid rounded border" style="max-height: 150px">
                                @endif
                            </div>
                            <small class="text-muted d-block mt-2">Recommended size: 825px X 550px</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn {{ $isEditMode ? 'btn-success' : 'btn-primary' }} px-4">
                            <span wire:loading.remove wire:target="save">Save Banner</span>
                            <span wire:loading wire:target="save">Processing...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const bModal = new bootstrap.Modal(document.getElementById('bannerModal'));
        window.addEventListener('open-modal', () => bModal.show());
        window.addEventListener('close-modal', () => bModal.hide());
    </script>
    @endpush
</div>