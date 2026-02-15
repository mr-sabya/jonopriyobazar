@extends('front.layouts.app')

@section('title')
Order#{{ $order->invoice }}
@endsection

@section('content')
<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="container">


            <div class="row">

                <div class="col-md-12">
                    <div class="order_review">
                        <div class="row">
                            <div class="col-6">
                                <div class="heading_s1 m-0">
                                    <div class="order-info">
                                        <h6>Order: #{{ $order->invoice }}</h6>
                                        <p class="m-0">Placed On: {{ date('d-m-Y', strtotime($order->created_at)) }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-6 text-right">
                                <a class="btn btn-warning {{ $order->status < 2 ? '' : 'disabled' }}" href="{{ route('user.order.cencel', $order->invoice)}}">Cancel</a>
                            </div>
                            
                        </div>
                        

                    </div>
                </div>
                <div class="col-md-12 mt-5">

                    <h3>My Orders / Tracking</h3>
                    <div class="order_review">
                        <div class="track">
                            <div class="step {{ $order->status == 1 || $order->status == 2 || $order->status == 3 ? 'active' : '' }}"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order confirmed</span> </div>
                            <div class="step {{ $order->status == 2 || $order->status == 3 ? 'active' : '' }}"> <span class="icon"> <i class="fa fa-spinner"></i> </span> <span class="text"> Processing</span> </div>
                            
                            <div class="step {{ $order->status == 3 ? 'active' : '' }}"> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">Delivered</span> </div>
                        </div>
                        <div class="history border-top pt-3" style="margin-top: 100px;">
                            @foreach($order->histories as $history)
                            <p class="m-0">{{ date('d-m-Y h:i A', strtotime($history->date_time)) }} &nbsp;&nbsp;&nbsp;&nbsp; {{ $history->status['name'] }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-5">
                    <div class="order_review">
                        <div class="table-responsive order_table mt-5">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <a href="">
                                                <img src="{{ url('upload/images', $item->product->image) }}" alt="cart_thumb1" style="width: 50px">
                                            </a>
                                        </td>
                                        <td>{{ $item->product['name']}} - {{ $item->product['quantity'] }} </td>
                                        <td class="text-center"> 
                                            @if($order->payment_option == 'wallet')
                                            {{ $item->product['actual_price'] }}
                                            @else
                                            {{ $item->product['sale_price'] }}
                                            @endif
                                        </td>
                                        <td class="text-center"> {{ $item->quantity }}</td>
                                        <td style="text-align: right;">{{ $item->price }}৳</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4">SubTotal</th>
                                        <td style="text-align: right;" class="product-subtotal">{{ $order->sub_total }}৳</td>
                                    </tr>
                                    <tr>
                                        <th colspan="4">Cupon</th>
                                        <td style="text-align: right;" class="product-subtotal">@if($order->cupon_id != null)
                                            - {{ $order->cupon['amount']}}৳
                                            @else
                                            No Cupon
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="4">Delivery Charge</th>
                                        <td style="text-align: right;">+ {{ $order->shippingAddress['city']['delivery_charge'] }}৳</td>
                                    </tr>
                                    <tr>
                                        <th colspan="4">Total</th>
                                        <td style="text-align: right;" class="product-subtotal">


                                            <span id="total">{{ $order->grand_total }}</span>৳
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="row" style="margin-top: 100px">
                            <div class="col-md-6">
                                <h4>Shipping Address</h4>
                                <p><strong>{{ $order->shippingAddress['name'] }}</strong><br>
                                    {{ $order->shippingAddress['street'] }},<br> {{ $order->shippingAddress['city']['name'] }} - {{ $order->shippingAddress['post_code']}}, {{ $order->shippingAddress['thana']['name'] }}, {{ $order->shippingAddress['district']['name']}}<br>
                                    {{ $order->shippingAddress['phone']}}<br>
                                    <span class="badge badge-warning">
                                        @if($order->shippingAddress['type'] == 'home') Home @else Office @endif
                                    </span>
                                </p>

                            </div>

                            <div class="col-md-6">
                                <h4>Billing Address</h4>
                                <p><strong>{{ $order->billingAddress['name'] }}</strong><br>
                                    {{ $order->billingAddress['street'] }},<br> {{ $order->billingAddress['city']['name'] }} - {{ $order->billingAddress['post_code']}}, {{ $order->billingAddress['thana']['name'] }}, {{ $order->billingAddress['district']['name']}}<br>
                                    {{ $order->billingAddress['phone']}}<br>
                                    <span class="badge badge-warning">
                                        @if($order->billingAddress['type'] == 'home') Home @else Office @endif
                                    </span>
                                </p>
                            </div>
                        </div>



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