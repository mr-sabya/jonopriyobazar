<div>
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 fw-bold text-primary">Product Inventory</h5>
            @can('admin.products.create')
                <a href="{{ route('admin.products.create') }}" wire:navigate class="btn btn-primary btn-sm px-3">
                    <i class="fas fa-plus me-1"></i> Add Product
                </a>
            @endcan
        </div>
        <div class="card-body">
            <div class="row g-3 mb-4">
                <div class="col-md-1">
                    <select wire:model.live="perPage" class="form-select form-select-sm">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="col-md-7"></div>
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                            placeholder="Search products...">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">#</th>
                            <th width="8%">Image</th>
                            <th style="cursor:pointer" wire:click="sortBy('name')">Product Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Categories</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $index => $product)
                            <tr>
                                <td>{{ $products->firstItem() + $index }}</td>
                                <td>
                                    <img src="{{ asset('upload/images/' . $product->image) }}" class="rounded shadow-sm"
                                        width="45" height="45" style="object-fit: cover">
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $product->name }}</div>
                                    <small class="text-muted">{{ $product->slug }}</small>
                                </td>
                                <td>
                                    <span class="text-primary fw-bold">{{ number_format($product->sale_price, 2) }}</span>
                                    @if($product->actual_price) <br><del
                                    class="text-muted small">{{ number_format($product->actual_price, 2) }}</del> @endif
                                </td>
                                <td>
                                    @if($product->is_stock)
                                        <span
                                            class="badge bg-success-soft text-success border border-success px-2">{{ $product->quantity }}
                                            In Stock</span>
                                    @else
                                        <span class="badge bg-danger-soft text-danger border border-danger px-2">Out of
                                            Stock</span>
                                    @endif
                                </td>
                                <td>
                                    @foreach($product->categories as $cat)
                                        <span class="badge bg-light text-dark border me-1">{{ $cat->name }}</span>
                                    @endforeach
                                </td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        @can('admin.products.edit')
                                            <a href="{{ route('admin.products.edit', $product->id) }}" wire:navigate
                                                class="btn btn-sm btn-outline-secondary border-0"><i
                                                    class="fas fa-edit"></i></a>
                                        @endcan
                                        @can('admin.products.delete')
                                            <button
                                                onclick="confirm('Delete this product?') || event.stopImmediatePropagation()"
                                                wire:click="delete({{ $product->id }})"
                                                class="btn btn-sm btn-outline-danger border-0"><i
                                                    class="fas fa-trash"></i></button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $products->links() }}</div>
        </div>
    </div>
</div>