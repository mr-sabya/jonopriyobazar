@extends('layouts.front')

@section('title', 'All Categories')

@section('content')
<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive shop_cart_table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">&nbsp;</th>
                                    <th class="product-name">Product</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-subtotal">Total</th>
                                    <th class="product-remove">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($carts as $cart)
                                <tr>
                                    <td class="product-thumbnail">
                                        <a href="#"><img src="{{ url('upload/images', $cart->product['image'])}}" alt="product1"></a>
                                    </td>
                                    <td class="product-name" data-title="Product">
                                        <a href="#">{{ $cart->product['name'] }}</a>
                                    </td>
                                    <td class="product-price" data-title="Price">{{ $cart->product['sale_price'] }}৳</td>
                                    <td class="product-quantity" data-title="Quantity"><div class="quantity">
                                        <input type="button" value="-" class="minus" data-id="{{ $cart->id }}" data-price="{{ $cart->product['sale_price']}}">
                                        <input type="text" name="quantity" id="quantity_{{ $cart->id }}" value="{{ $cart->quantity }}" title="Qty" class="qty" size="4" readonly>
                                        <input type="button" value="+" class="plus" data-id="{{ $cart->id }}" data-price="{{ $cart->product['sale_price']}}">
                                    </div></td>
                                    <td class="product-subtotal" data-title="Total"><span id="cart_total_{{ $cart->id }}">{{ $cart->price }}</span>৳</td>
                                    <td class="product-remove" data-title="Remove">
                                        <a href="javascript:void(0)">
                                            <i class="ti-close"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="px-0">
                                        <div class="row no-gutters align-items-center">

                                            <div class="col-lg-4 col-md-6 mb-3 mb-md-0">
                                                <div class="coupon field_form input-group">
                                                    <input type="text" value="" class="form-control form-control-sm" placeholder="Enter Coupon Code..">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-fill-out btn-sm" type="submit">Apply Coupon</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-md-6 text-left text-md-right">
                                                <button class="btn btn-line-fill btn-sm" type="submit">Update Cart</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="medium_divider"></div>
                    <div class="divider center_icon"><i class="ti-shopping-cart-full"></i></div>
                    <div class="medium_divider"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="heading_s1 mb-3">
                        <h6>Calculate Shipping</h6>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="border p-3 p-md-4">
                        <div class="heading_s1 mb-3">
                            <h6>Cart Totals</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="cart_total_label">Cart Subtotal</td>
                                        <td class="cart_total_amount">{{ $carts->sum('price')}}৳</td>
                                    </tr>
                                    <tr>
                                        <td class="cart_total_label">Shipping</td>
                                        <td class="cart_total_amount">{{ $carts->sum('price')}}৳</td>
                                    </tr>
                                    <tr>
                                        <td class="cart_total_label">Total</td>
                                        <td class="cart_total_amount"><strong>$349.00</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <a href="#" class="btn btn-fill-out">Proceed To CheckOut</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->

</div>
<!-- END MAIN CONTENT -->

@endsection

@section('script')
<script>
    $('.plus').on('click', function() {
        if ($(this).prev().val()) {
            var cart_id = $(this).attr('data-id');
            var price = $(this).attr('data-price');
            var quantity = $('#quantity_'+cart_id).val();

            var final_quantity = parseInt(quantity) + 1;

            $('#quantity_'+cart_id).val(parseInt(final_quantity));

            var total = parseInt(final_quantity) * parseInt(price);
            $('#cart_total_'+cart_id).html(parseInt(total));

            $.ajax({
                url: "/cart/increment/"+ cart_id,
                dataType: "json",
                success: function (data) {
                    console.log('success');

                }
            });
        }
    });
    $('.minus').on('click', function() {
        if ($(this).next().val() > 1) {
            if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
        }
    });
</script>
@endsection