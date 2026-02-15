<section class="stickyCart" id="get_cart" style="cursor: pointer;">
    <div class="cartItem">
        <div class="cart-icon" style="padding: 4px 0; font-size: 20px">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <span>
            <span id="view_cart">{{ $totalItems }}</span> ITEMS
        </span>
    </div>
    <div class="total">
        <p>
            ৳ <span id="view_subtotal" class="odometer-value">{{ number_format($totalPrice, 0) }}</span>
        </p>
    </div>
</section>