<div class="product-wrapper">
    <div class="product-card  border rounded bg-white overflow-hidden">
        <div class="product-img-wrapper position-relative text-center p-3">
            <!-- Product Badges -->
            <div class="product-badges position-absolute">
                @if($product->off)
                <span class="badge badge-danger off-badge">{{ $product->off }}% OFF</span>
                @endif
                @if($product->point > 0)
                <span class="badge badge-warning point-badge d-block mt-1">
                    <i class="fas fa-coins"></i> {{ $product->point }}
                </span>
                @endif
            </div>

            <!-- Image -->
            <a href="javascript:void(0)" wire:click="$dispatch('loadQuickView', { productId: {{ $product->id }} })" class="d-block">
                <img src="{{ url('upload/images', $product->image) }}"
                    alt="{{ $product->name }}"
                    class="img-fluid main-img">
            </a>

            <!-- Quick Actions -->
            <div class="product-hover-actions">
                <button wire:click="addToWishlist" class="action-btn" title="Add to Wishlist">
                    <i class="lnr lnr-heart"></i>
                </button>
                <button wire:click="$dispatch('loadQuickView', { productId: {{ $product->id }} })"class="action-btn mt-2">
                    <i class="lnr lnr-magnifier"></i>
                </button>
            </div>
        </div>

        <div class="product-info-wrapper p-3 text-left">
            <!-- Title & Quantity -->
            <h6 class="product-name mb-1">
                <a href="javascript:void(0)" wire:click="$dispatch('loadQuickView', { productId: {{ $product->id }} })" class="text-dark text-decoration-none">
                    {{ str($product->name)->limit(15) }} ({{ $product->quantity }})
                </a>
            </h6>

            <!-- Pricing -->
            <div class="product-pricing mb-3">
                <span class="current-price font-weight-bold">৳{{ $product->sale_price }}</span>
                @if($product->actual_price > $product->sale_price)
                <del class="old-price text-muted ml-2 small">৳{{ $product->actual_price }}</del>
                @endif
            </div>

            <!-- Add to Cart Button -->
            <button wire:click="addToCart"
                wire:loading.attr="disabled"
                class="btn btn-add-cart btn-block rounded-pill-custom">
                <span wire:loading.remove wire:target="addToCart">
                    <i class="icon-basket-loaded mr-2"></i> Add to Bag
                </span>
                <span wire:loading wire:target="addToCart">Adding...</span>
            </button>
        </div>


        <!-- --- QUICK VIEW MODAL --- -->

    </div>

</div>