<div class="section">
    <div class="custom-container">
        <div class="row">
            <!-- Sidebar (Responsive) -->
            

            <!-- Product Grid -->
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center mb-4 w-100">
                    <div>
                        <h5>Sort By</h5>
                    </div>
                    <select wire:model.live="sort" class="form-select">
                        <option value="name-asc">Name (A-Z)</option>
                        <option value="name-desc">Name (Z-A)</option>
                        <option value="price-low">Price (Low to High)</option>
                        <option value="price-high">Price (High to Low)</option>
                    </select>
                </div>
                <div class="row">
                    @forelse($products as $product)
                    <div class="col-lg-2 col-md-4 col-sm-6 col-6" style="margin-bottom: 30px;" wire:key="prod-{{ $product->id }}">
                        <livewire:frontend.components.product :productId="$product->id" :key="'item-'.$product->id" />
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <h4>No products found.</h4>
                    </div>
                    @endforelse
                </div>

                <!-- Infinite Scroll Trigger -->
                <!-- Infinite Scroll Trigger -->
                @if($products->hasMorePages())
                <div x-intersect="$wire.loadMore()" class="text-center py-4">
                    <!-- This div is hidden by default and only shows when Livewire is working -->
                    <div wire:loading wire:target="loadMore">
                        <div class="spinner-border text-success" role="status"></div>
                        <p class="mt-2">Loading...</p>
                    </div>

                    <!-- This div shows when NOT loading, telling the user to scroll more -->
                    <div wire:loading.remove wire:target="loadMore">
                        <p class="text-muted">Scroll down for more</p>
                    </div>
                </div>
                @else
                <div class="text-center py-4">
                    <p class="text-muted">You've reached the end of the catalog.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>