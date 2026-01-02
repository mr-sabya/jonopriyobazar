@extends('layouts.front')

@section('title', 'Checkout')

@section('content')
<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="container">

            @if($carts->count()>0)
            <div class="row">
                <div class="col-md-6">
                    <div class="heading_s1">
                        <h4>Shipping & Billing  <a href="{{ route('user.address.index')}}" style="font-size: 14px;"><i class="fas fa-pencil-alt"></i> Change</a></h4>
                    </div>

                    <div class="address">


                        <div class="default-address">
                            <h6>Default Shipping Address</h6>
                            <div class="point">
                                <div class="icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="text">
                                    <p><span>{{ $shipping_address->name}}</span><br>
                                        {{ $shipping_address->street }}<br>
                                        {{ $shipping_address->city['name'] }} - {{ $shipping_address->post_code }}, {{ $shipping_address->thana['name'] }}, {{ $shipping_address->district['name'] }}<br>
                                        <strong>{{ $shipping_address->phone }}</strong>

                                    </p>
                                </div>

                            </div>

                            <h6>Default Billing Address</h6>
                            <div class="point">
                                <div class="icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="text">
                                    <p><span>{{ $billing_address->name}}</span><br>
                                        {{ $billing_address->street }}<br>
                                        {{ $billing_address->city['name'] }} - {{ $billing_address->post_code }}, {{ $billing_address->thana['name'] }}, {{ $billing_address->district['name'] }}<br>
                                        <strong>{{ $billing_address->phone }}</strong>

                                    </p>
                                </div>

                            </div>
                            <hr>
                            <div class="point">
                                <div class="icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="text">
                                    <p>{{ Auth::user()->phone }}</p>
                                </div>
                            </div>
                            
                        </div>

                        
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="order_review">
                        <div class="heading_s1">
                            <h4>Your Orders</h4>
                        </div>
                        <div class="table-responsive order_table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($carts as $cart)
                                    <tr>
                                        <td>
                                            <a href="">
                                                <img src="{{ url('upload/images', $cart->product->image) }}" alt="cart_thumb1" style="width: 50px">
                                            </a>
                                        </td>
                                        <td>{{ $cart->product['name']}} - {{ $cart->product['quantity'] }} <span class="product-qty">x {{ $cart->quantity }}</span></td>
                                        <td style="text-align: right;">{{ $cart->price }}৳</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">SubTotal</th>
                                        <td style="text-align: right;" class="product-subtotal">{{ $carts->sum('price')}}৳</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Shipping</th>
                                        <td style="text-align: right;">{{ $shipping_address->city['delivery_charge'] }}৳</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Total</th>
                                        <td style="text-align: right;" class="product-subtotal">
                                            @php
                                            $total = $carts->sum('price') + $shipping_address->city['delivery_charge'];
                                            @endphp

                                            <span id="total">{{ $total }}</span>৳
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="cupon" id="cupon">
                            <div class="toggle_info">
                                <span><i class="fas fa-tag"></i>Have a coupon? <a href="#coupon" data-toggle="collapse" class="collapsed" aria-expanded="false">Click here to enter your code</a></span>
                            </div>
                            <div class="panel-collapse collapse coupon_form" id="coupon">
                                <div class="panel-body">
                                    <p>If you have a coupon code, please apply it below.</p>
                                    <form id="cupon_form" action="{{ route('cupon.apply')}}" method="post">
                                        @csrf
                                        <div class="coupon field_form input-group">
                                            <input type="hidden" name="total" value="{{ $carts->sum('price') }}">
                                            <input type="text" value="" class="form-control" placeholder="Enter Coupon Code.." name="code">
                                            <div class="input-group-append">
                                                <button class="btn btn-fill-out btn-sm" type="submit">Apply Coupon</button>
                                            </div>
                                        </div>
                                        <small style="color: red" id="cupon_error"></small>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="added_cupon" style="display: none;">
                            <div class="added-cupon">
                                <p class="text-center">You have use cupon for <span class="taka"><span id="cupon_amoun">10</span>৳</span></p>
                            </div>
                            <div class="remove-cupon">
                                <a id="remove_cupon" href="javascript:void(0)" cupon-id=""><i class="fas fa-times"></i> Remove Cupon</a>
                            </div>
                        </div>
                        <form action="{{ route('user.order') }}" method="post">
                            @csrf
                            <input type="hidden" name="cupon_id" id="cupon_id">
                            <input type="hidden" name="shipping_address_id" id="shipping_address_id" value="{{ $shipping_address->id }}">
                            <input type="hidden" name="billing_address_id" id="billing_address_id" value="{{ $billing_address->id }}">
                            <input type="hidden" name="delivery_charge" value="{{ $shipping_address->city['delivery_charge']}}">
                            <div class="payment_method mt-5">
                                <div class="heading_s1">
                                    <h4>Payment</h4>
                                </div>
                                <div class="payment_option">
                                    <div class="custome-radio">
                                        <input class="form-check-input" required="" type="radio" name="payment_option" id="cash_on_delivery" value="cash" checked="">
                                        <label class="form-check-label" for="cash_on_delivery">Cash On Delivery</label>

                                    </div>

                                    @if(Auth::user()->is_wallet == 1)

                                    @if(Auth::user()->wallet_balance < $total)
                                    <div class="custome-radio">
                                        <input class="form-check-input" type="radio" name="payment_option" id="wallet_radio" value="wallet" disabled>
                                        <label class="form-check-label" for="wallet_radio">Wallet Balance is Low</label>

                                    </div>
                                    @elseif(Auth::user()->is_hold == 1)
                                    <div class="custome-radio">
                                        <input class="form-check-input" type="radio" name="payment_option" id="wallet_radio" value="wallet" disabled>
                                        <label class="form-check-label" for="wallet_radio">Credit Wallet id Hold</label>

                                    </div>
                                    @elseif(Auth::user()->is_expired == 1)
                                    <div class="custome-radio">
                                        <input class="form-check-input" type="radio" name="payment_option" id="wallet_radio" value="wallet" disabled>
                                        <label class="form-check-label" for="wallet_radio">Credit Wallet id Expired</label>

                                    </div>
                                    @else
                                    <div class="custome-radio">
                                        <input class="form-check-input" type="radio" name="payment_option" id="wallet_radio" value="wallet">
                                        <label class="form-check-label" for="wallet_radio">Credit Wallet</label>

                                    </div>
                                    @endif
                                    @endif
                                    @if(Auth::user()->is_percentage == 1)

                                    @if(Auth::user()->ref_balance < $total)
                                    <div class="custome-radio">
                                        <input class="form-check-input" type="radio" name="payment_option" id="refer_radio" value="reffer" disabled>
                                        <label class="form-check-label" for="refer_radio">Reffer Wallet balance is Low</label>

                                    </div>
                                    @else
                                    <div class="custome-radio">
                                        <input class="form-check-input" type="radio" name="payment_option" id="refer_radio" value="refer">
                                        <label class="form-check-label" for="refer_radio">Reffer Wallet</label>

                                    </div>
                                    @endif
                                    @endif
                                </div>
                            </div>
                            <button type="submit" class="btn btn-fill-out btn-block">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3>Your Cart is Empty</h3>
                    <a class="btn btn-fill-out" href="{{ route('product.index')}}">Go to Shop</a>
                </div>
            </div>
            @endif
        </div>
    </div>
    <!-- END SECTION SHOP -->

</div>
<!-- END MAIN CONTENT -->

@endsection

@section('script')
<script>

    $('#cupon_form').on('submit', function (event) {
        event.preventDefault();
        
        $.ajax({
            url: "{{ route('cupon.apply') }}",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            
            success: function (data) {

                if (data.error) {
                    $('#cupon_error').html(data.error);
                    $('#cupon_form')[0].reset();
                }
                if (data.cupon) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Thanks for using cupon!',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    var total = $('#total').html();
                    var off = data.cupon.amount;

                    var final = parseInt(total) - parseInt(off);
                    $('#total').html(parseInt(final));
                    $('#cupon').hide();
                    $('#added_cupon').show();
                    $('#cupon_id').val(data.cupon.id);
                    $('#remove_cupon').attr('cupon-id', data.cupon.id);
                    $('#cupon_amoun').html(data.cupon.amount);
                }

            }
        })
        
    });

    $('#remove_cupon').click(function(event) {
        var cupon_id = $(this).attr('cupon-id');
        $.ajax({
            url: "/cupon/remove/"+cupon_id,
            method: "GET",
            success: function (data) {
                if (data.cupon) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'This Cupon has been removed!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    $('#cupon_form')[0].reset();
                    var total = $('#total').html();
                    var off = data.cupon.amount;

                    var final = parseInt(total) + parseInt(off);
                    $('#total').html(parseInt(final));
                    $('#added_cupon').hide();
                    $('#cupon').show();
                    $('#cupon_id').val('');
                }

            }
        })
    });


</script>
@endsection