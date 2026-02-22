<div class="main_content">
    <div class="section">
        <div class="container">
            @if($this->carts->count() > 0)
            <div class="row">
                <!-- SHIPPING & BILLING (REVERTED TO YOUR ORIGINAL DESIGN) -->
                <!-- LEFT COLUMN: UPDATED ADDRESS DESIGN -->
                <div class="col-md-6">
                    <div class="heading_s1 d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Shipping & Billing</h4>
                        <a href="{{ route('user.address.index') }}" wire:navigate class="fw-bold text-main-green" style="font-size: 14px; text-decoration: none;">
                            <i class="fas fa-pencil-alt"></i> Change Address
                        </a>
                    </div>

                    <!-- Main Address Container -->
                    <div class="address shadow-sm p-4 br-15 bg-white border">

                        <!-- Shipping Address Block -->
                        <div class="default-address mb-4">
                            <h6 class="text-uppercase small fw-bold text-muted mb-3" style="letter-spacing: 1px;">
                                <i class="fas fa-truck-moving me-1"></i> Delivery Address
                            </h6>
                            <div class="point">
                                <div class="icon" style="color: var(--shwapno-green); font-size: 18px;">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="text">
                                    <p class="mb-0">
                                        <span class="fw-bold fs-6" style="color: #333;">{{ $shipping_address->name }}</span><br>
                                        <span class="text-secondary">{{ $shipping_address->street }}</span><br>
                                        <span class="text-secondary">
                                            {{ $shipping_address->city['name'] }} - {{ $shipping_address->post_code }},
                                            {{ $shipping_address->thana['name'] }}, {{ $shipping_address->district['name'] }}
                                        </span><br>
                                        <strong class="text-main-green d-block mt-1">{{ $shipping_address->phone }}</strong>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Separator with dashed line -->
                        <hr class="my-4" style="border-top: 1px dashed #e0e0e0;">

                        <!-- Billing Address Block -->
                        <div class="default-address mb-2">
                            <h6 class="text-uppercase small fw-bold text-muted mb-3" style="letter-spacing: 1px;">
                                <i class="fas fa-file-invoice-dollar me-1"></i> Billing Address
                            </h6>
                            <div class="point">
                                <div class="icon" style="color: var(--shwapno-green); font-size: 18px;">
                                    <i class="fas fa-receipt"></i>
                                </div>
                                <div class="text">
                                    <p class="mb-0">
                                        <span class="fw-bold fs-6" style="color: #333;">{{ $billing_address->name }}</span><br>
                                        <span class="text-secondary">{{ $billing_address->street }}</span><br>
                                        <strong class="text-main-green d-block mt-1">{{ $billing_address->phone }}</strong>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Optional User Info Line -->
                        <div class="mt-4 pt-3 border-top">
                            <div class="point">
                                <div class="icon text-muted"><i class="fas fa-user-circle"></i></div>
                                <div class="text">
                                    <p class="small text-muted mb-0">Registered Phone: {{ Auth::user()->phone }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ORDER REVIEW (REVERTED TO YOUR ORIGINAL DESIGN) -->
                <div class="col-md-6">
                    <div class="order_review p-4 br-15 bg-white shadow-sm">
                        <div class="heading_s1">
                            <h4>Your Orders</h4>
                        </div>
                        <div class="table-responsive order_table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th style="text-align: right;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($this->carts as $cart)
                                    <tr>
                                        <td>
                                            <img src="{{ url('upload/images', $cart->product->image) }}" alt="img" style="width: 50px">
                                        </td>
                                        <td>
                                            {{ $cart->product['name'] }} - {{ $cart->product['quantity'] }}
                                            <span class="product-qty">x {{ $cart->quantity }}</span>
                                            <br>
                                            <small class="text-muted">
                                                @if($payment_option === 'wallet' || $payment_option === 'refer')
                                                Rate: {{ $cart->product->actual_price }}৳
                                                @else
                                                Rate: {{ $cart->price / $cart->quantity }}৳
                                                @endif
                                            </small>
                                        </td>
                                        <td style="text-align: right;">
                                            @if($payment_option === 'wallet' || $payment_option === 'refer')
                                            {{ $cart->product->actual_price * $cart->quantity }}৳
                                            @else
                                            {{ $cart->price }}৳
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">SubTotal</th>
                                        <td style="text-align: right;">{{ $subtotal }}৳</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Shipping</th>
                                        <td style="text-align: right;">{{ $delivery_charge }}৳</td>
                                    </tr>
                                    @if($applied_coupon)
                                    <tr class="text-danger">
                                        <th colspan="2">Coupon Discount</th>
                                        <td style="text-align: right;">-{{ $applied_coupon['amount'] }}৳</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th colspan="2">Total</th>
                                        <td style="text-align: right;"><span id="total" class="fw-bold text-success" style="font-size: 20px;">{{ $this->finalTotal }}</span>৳</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- COUPON DESIGN (ORIGINAL) -->
                        <div class="cupon mt-3">
                            @if(!$applied_coupon)
                            <div class="coupon field_form input-group">
                                <input type="text" wire:model="coupon_code" class="form-control" placeholder="Enter Coupon Code..">
                                <div class="input-group-append">
                                    <button wire:click="applyCoupon" class="btn btn-fill-out btn-sm" type="button">Apply Coupon</button>
                                </div>
                            </div>
                            @error('coupon_error') <small style="color: red">{{ $message }}</small> @enderror
                            @else
                            <div class="added-cupon bg-success text-white p-2 br-10 d-flex justify-content-between">
                                <span>Coupon Applied: <b>{{ $applied_coupon['code'] }}</b></span>
                                <a href="javascript:void(0)" wire:click="removeCoupon" class="text-white"><i class="fas fa-times"></i></a>
                            </div>
                            @endif
                        </div>

                        <!-- PAYMENT OPTION (ORIGINAL RADIO PATTERN) -->
                        <div class="payment_method mt-5">
                            <div class="heading_s1">
                                <h4>Payment</h4>
                            </div>
                            <div class="payment_option">
                                <div class="custome-radio mb-2">
                                    <input class="form-check-input" type="radio" wire:model.live="payment_option" id="cash_on_delivery" value="cash">
                                    <label class="form-check-label" for="cash_on_delivery">Cash On Delivery</label>
                                </div>

                                @php $total = $this->finalTotal; @endphp

                                @if(Auth::user()->is_wallet == 1)
                                <div class="custome-radio mb-2">
                                    <input class="form-check-input" type="radio" wire:model.live="payment_option" id="wallet_radio" value="wallet"
                                        {{ (Auth::user()->wallet_balance < $total || Auth::user()->is_hold) ? 'disabled' : '' }}>
                                    <label class="form-check-label" for="wallet_radio">Credit Wallet (Balance: {{ Auth::user()->wallet_balance }}৳)</label>
                                </div>
                                @endif

                                @if(Auth::user()->is_percentage == 1)
                                <div class="custome-radio mb-2">
                                    <input class="form-check-input" type="radio" wire:model.live="payment_option" id="refer_radio" value="refer"
                                        {{ Auth::user()->ref_balance < $total ? 'disabled' : '' }}>
                                    <label class="form-check-label" for="refer_radio">Refer Wallet (Balance: {{ Auth::user()->ref_balance }}৳)</label>
                                </div>
                                @endif
                            </div>
                        </div>

                        <button wire:click="placeOrder" wire:loading.attr="disabled" class="btn btn-login w-100 text-white mt-3">
                            <span wire:loading.remove>Place Order</span>
                            <span wire:loading>Processing...</span>
                        </button>
                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-md-12 text-center py-5">
                    <h3>Your Cart is Empty</h3>
                    <a class="btn btn-fill-out bg-main-green text-white" href="{{ route('product.index') }}">Go to Shop</a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>