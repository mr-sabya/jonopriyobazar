<div class="container-fluid py-4">
    <form wire:submit.prevent="save">
        <div class="row">
            <!-- Left Column: Main Content -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 fw-bold text-primary">Product Information</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Product Title</label>
                            <input type="text" wire:model.live="name"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Enter name">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Slug (Auto-generated)</label>
                            <input type="text" wire:model="slug"
                                class="form-control @error('slug') is-invalid @enderror">
                        </div>
                        <div class="mb-0" wire:ignore>
                            <label class="form-label fw-bold small">Description</label>
                            <livewire:quill-text-editor wire:model.live="description" theme="snow" />
                            <style>
                                .ql-editor {
                                    min-height: 400px;
                                }
                            </style>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 fw-bold text-primary">Pricing & Inventory</div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Sale Price</label>
                                <input type="number" wire:model="sale_price"
                                    class="form-control @error('sale_price') is-invalid @enderror">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Actual Price</label>
                                <input type="number" wire:model="actual_price" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Quantity (Pieces/KG)</label>
                                <input type="text" wire:model="quantity" class="form-control"
                                    placeholder="e.g. 100 pcs">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">% Off</label>
                                <input type="number" wire:model="off" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Points</label>
                                <input type="number" wire:model="point" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar -->
            <div class="col-lg-4">
                <!-- Status Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" wire:model="is_stock" id="stockSwitch">
                            <label class="form-check-label fw-bold" for="stockSwitch">In Stock</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" wire:model="is_percentage" id="percSwitch">
                            <label class="form-check-label fw-bold" for="percSwitch">Partner Percentage</label>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <span wire:loading class="spinner-border spinner-border-sm me-1"></span>
                            {{ $isEditMode ? 'Update Product' : 'Publish Product' }}
                        </button>
                    </div>
                </div>

                <!-- Media Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 fw-bold small">Product Image</div>
                    <div class="card-body text-center">
                        @if($image)
                            <img src="{{ $image->temporaryUrl() }}" class="img-fluid rounded border mb-2">
                        @elseif($oldImage)
                            <img src="{{ asset('upload/images/' . $oldImage) }}" class="img-fluid rounded border mb-2">
                        @else
                            <div class="py-4 border rounded bg-light text-muted mb-2">
                                <i class="fas fa-image fa-3x"></i><br>No Image Selected
                            </div>
                        @endif
                        <input type="file" wire:model="image" class="form-control form-control-sm">
                        @error('image') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Categories Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 fw-bold small">Categories</div>
                    <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                        @foreach($categories as $parent)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="selectedCategories"
                                    value="{{ $parent->id }}" id="cat{{ $parent->id }}">
                                <label class="form-check-label fw-bold"
                                    for="cat{{ $parent->id }}">{{ $parent->name }}</label>
                            </div>
                            @foreach($parent->sub as $sub)
                                <div class="form-check ms-3">
                                    <input class="form-check-input" type="checkbox" wire:model="selectedCategories"
                                        value="{{ $sub->id }}" id="cat{{ $sub->id }}">
                                    <label class="form-check-label small" for="cat{{ $sub->id }}">{{ $sub->name }}</label>
                                </div>
                            @endforeach
                        @endforeach
                        @error('selectedCategories') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>