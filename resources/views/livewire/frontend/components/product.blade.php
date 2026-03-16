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
                <img src="{{ $product->image_url }}"
                    alt="{{ $product->name }}"
                    class="img-fluid main-img">
            </a>

            <!-- Quick Actions -->
            <div class="product-hover-actions">
                <!-- Wrap the button or the whole card in x-data -->
                <div x-data="{ localWishlisted: @entangle('isInWishlist') }">
                    <button type="button"
                        @click="localWishlisted = !localWishlisted; $wire.addToWishlist()"
                        class="action-btn"
                        :class="localWishlisted ? 'is-wishlisted' : ''"
                        title="Wishlist">

                        <!-- Icon changes instantly based on Alpine state -->
                        <template x-if="localWishlisted">
                            <i class="fas fa-heart"></i>
                        </template>

                        <template x-if="!localWishlisted">
                            <i class="lnr lnr-heart"></i>
                        </template>
                    </button>
                </div>
                <button wire:click="$dispatch('loadQuickView', { productId: {{ $product->id }} })" class="action-btn mt-2">
                    <i class="lnr lnr-eye"></i>
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

            @if($product->is_stock == 1)
            <!-- Add to Cart Button -->
            <button wire:click="addToCart"
                wire:loading.attr="disabled"
                class="btn btn-add-cart btn-block rounded-pill-custom">
                <span wire:loading.remove wire:target="addToCart">
                    <i class="icon-basket-loaded mr-2"></i> Add to Bag
                </span>
                <span wire:loading wire:target="addToCart">Adding...</span>
            </button>
            @else
            <button class="btn btn-add-cart-disable btn-block rounded-pill-custom" disabled>
                Out of Stock
            </button>
            @endif
        </div>


        <!-- --- QUICK VIEW MODAL --- -->

    </div>

    <style>
        /* Normal state */
        .action-btn {
            background: #ffffff;
            border: 1px solid #e1e1e1;
            color: #333;
            transition: all 0.3s ease;
        }

        /* Wishlisted state (Change color here) */
        .action-btn.is-wishlisted {
            background-color: #ffeded !important;
            /* Soft red background */
            border-color: #ff0000 !important;
            /* Red border */
            color: #ff0000 !important;
            /* Red heart icon */
        }

        /* Optional: Pop animation when clicked */
        .is-wishlisted i {
            animation: heartPop 0.3s ease-out;
        }

        @keyframes heartPop {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.3);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>

</div>