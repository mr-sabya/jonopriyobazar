<div>
    <!-- 1. SIDE CART OVERLAY (Background Dim) -->
    <div class="side-cart-overlay"></div>

    <div id="cart" class="shopping_cart side-cart-container" wire:ignore.self>
        <!-- Header Section -->
        <div class="cart-header d-flex align-items-center justify-content-between p-3">
            <div class="header-title">
                <h5 class="m-0 font-weight-bold text-white"><i class="lnr lnr-bag mr-2"></i>My Shopping Bag</h5>
                <span class="badge badge-light-transparent">{{ Auth::check() ? $carts->sum('quantity') : 0 }} Items</span>
            </div>
            <!-- CLOSE BUTTON -->
            <a href="javascript:void(0)" class="cart_close_btn_new">
                <i class="lnr lnr-cross"></i>
            </a>
        </div>

        <div class="shopping_cart_inner">
            @guest
            <div class="cart_empty_state text-center py-5">
                <div class="icon-circle mb-3"><i class="lnr lnr-lock"></i></div>
                <h6 class="font-weight-bold">Authentication Required</h6>
                <p class="text-muted small">Please log in to manage your items.</p>
                <a href="/login" class="btn btn-primary btn-sm br-10 px-4 mt-2">Login Now</a>
            </div>
            @else
            <div class="cart_product_list">
                @forelse($carts as $cart)
                <div class="cart_item_card d-flex align-items-center" wire:key="cart-item-{{ $cart->id }}">
                    <div class="qty-wrapper d-flex flex-column align-items-center">
                        <button wire:click.stop="increment({{ $cart->id }})" class="qty-btn plus"><i class="lnr lnr-chevron-up"></i></button>
                        <span class="qty-val">{{ $cart->quantity }}</span>
                        <button wire:click.stop="decrement({{ $cart->id }})" class="qty-btn minus"><i class="lnr lnr-chevron-down"></i></button>
                    </div>

                    <div class="product-thumb">
                        <img src="{{ url('upload/images', $cart->product->image) }}" alt="{{ $cart->product->name }}">
                    </div>

                    <div class="product-details flex-grow-1">
                        <h6 class="product-name text-truncate" title="{{ $cart->product->name }}">{{ $cart->product->name }}</h6>
                        <div class="price-box">
                            <span class="current-price">{{ number_format($cart->price, 2) }}৳</span>
                            @if($cart->product->actual_price > $cart->price)
                            <span class="old-price ml-1"><del>{{ number_format($cart->product->actual_price, 2) }}৳</del></span>
                            @endif
                        </div>
                        <div class="sub-total font-weight-bold">
                            Total: {{ number_format($cart->subtotal, 2) }}৳
                        </div>
                    </div>

                    <button wire:click="removeItem({{ $cart->id }})" class="remove-btn"><i class="lnr lnr-trash"></i></button>
                </div>
                @empty
                <div class="cart_empty_state text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/11329/11329060.png" style="width: 80px; opacity: 0.5;">
                    <h6 class="mt-3 font-weight-bold text-muted">Your bag is empty</h6>
                </div>
                @endforelse
            </div>
            @endguest
        </div>

        @auth
        @if($carts->count() > 0)
        <div class="cart_footer_new shadow-lg">
            <div class="summary-row d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted font-weight-bold">Total Amount</span>
                <span class="total-amount">{{ number_format($subtotal, 2) }}৳</span>
            </div>
            <a href="{{ route('checkout.index') }}" class="btn-checkout">
                <span>Proceed to Checkout</span>
                <i class="lnr lnr-arrow-right"></i>
            </a>
        </div>
        @endif
        @endauth
    </div>

    <style>
        /* 1. OVERLAY STYLING */
        .side-cart-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Semi-transparent black */
            z-index: 99998;
            /* Just below the sidecart */
            visibility: hidden;
            opacity: 0;
            transition: all 0.3s ease-in-out;
        }

        /* Show overlay when active */
        .side-cart-overlay.active {
            visibility: visible;
            opacity: 1;
        }

        /* 2. SIDECART CONTAINER */
        .side-cart-container {
            background: #fff;
            width: 350px;
            height: 100vh !important;
            position: fixed;
            top: 0;
            right: -350px;
            /* Hidden off-screen */
            z-index: 99999;
            box-shadow: -5px 0 30px rgba(0, 0, 0, 0.1);
            display: flex !important;
            flex-direction: column !important;
            visibility: hidden;
            transition: all 0.3s ease-in-out;
        }

        .side-cart-container.active {
            right: 0;
            /* Slide in */
            visibility: visible;
        }

        /* Layout & Internal Spacing */
        .shopping_cart_inner {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .cart_product_list {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
            overflow-x: hidden;
        }

        .cart_footer_new {
            flex-shrink: 0;
            padding: 20px;
            background: #fff;
            border-top: 1px solid #f0f0f0;
            margin-top: auto;
            box-shadow: 0 -10px 20px rgba(0, 0, 0, 0.05);
        }

        .cart-header {
            flex-shrink: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        .cart_close_btn_new {
            color: white;
            font-size: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .cart_close_btn_new:hover {
            transform: rotate(90deg);
            color: #ffd700;
        }

        .product-details {
            flex: 1;
            min-width: 0;
            padding-right: 10px;
        }

        .product-name {
            font-size: 13px;
            font-weight: 700;
            color: #2d3436;
            display: block;
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .price-box {
            font-size: 13px;
        }

        .sub-total {
            font-size: 14px;
            color: #43a047;
            font-weight: 700;
        }

        .cart_item_card {
            display: flex;
            align-items: center;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 12px;
            background: #fff;
            border-radius: 12px;
            padding: 10px;
            border: 1px solid #f5f5f5;
        }

        .qty-wrapper {
            background: #f8f9ff;
            border-radius: 8px;
            padding: 5px;
            border: 1px solid #eee;
        }

        .qty-btn {
            border: none;
            background: none;
            color: #667eea;
            cursor: pointer;
        }

        .product-thumb {
            width: 60px;
            height: 60px;
            margin: 0 12px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #f0f0f0;
        }

        .product-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .total-amount {
            font-size: 20px;
            font-weight: 800;
            color: #2d3436;
        }

        .btn-checkout {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #43a047;
            color: white !important;
            padding: 14px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
        }

        .badge-light-transparent {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 20px;
        }

        .remove-btn {
            background: #fff5f5;
            /* Soft light red background */
            color: #ff4d4d;
            /* Vibrant red icon color */
            border: 1px solid #ffebeb;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            padding: 0;
            margin-left: 10px;
            flex-shrink: 0;
            /* Prevents button from squishing */
        }

        .remove-btn:hover {
            background: #ff4d4d;
            /* Solid red background on hover */
            color: #ffffff;
            /* White icon on hover */
            border-color: #ff4d4d;
            transform: scale(1.1);
            /* Slight pop effect */
            box-shadow: 0 4px 10px rgba(255, 77, 77, 0.2);
        }

        .remove-btn i {
            font-size: 14px;
            font-weight: bold;
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            background: #f8f9ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 30px;
            color: #667eea;
        }

        @media (max-width: 480px) {
            .side-cart-container {
                width: 100%;
                right: -100%;
            }
        }
    </style>

    <!-- 3. JAVASCRIPT FOR TOGGLE -->
    <script>
        document.addEventListener('livewire:navigated', function() {
            const cartContainer = document.querySelector('.side-cart-container');
            const overlay = document.querySelector('.side-cart-overlay');
            const closeBtn = document.querySelector('.cart_close_btn_new');
            const openBtns = document.querySelectorAll('.stickyCart, #get_cart'); // Add any other selectors that open the cart

            // Function to close cart
            const closeCart = () => {
                cartContainer.classList.remove('active');
                overlay.classList.remove('active');
                document.body.style.overflow = ''; // Restore scroll
            };

            // Function to open cart
            const openCart = () => {
                cartContainer.classList.add('active');
                overlay.classList.add('active');
                document.body.style.overflow = 'hidden'; // Prevent background scroll
            };

            // Close when clicking Close Button
            closeBtn.addEventListener('click', closeCart);

            // Close when clicking Overlay
            overlay.addEventListener('click', closeCart);

            // Open when clicking sticky cart button
            openBtns.forEach(btn => {
                btn.addEventListener('click', openCart);
            });

            // Listen for Livewire events if you want to open it automatically after adding a product
            window.addEventListener('openSideCart', openCart);
        });
    </script>
</div>