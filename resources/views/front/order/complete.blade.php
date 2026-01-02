@extends('layouts.front')

@section('title')
Order Complete
@endsection

@section('content')
<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="text-center order_complete">
                        <i class="fas fa-check-circle"></i>
                        <div class="heading_s1">
                            <h3>Your order is completed!</h3>
                        </div>
                        <p>Thank you for your order! Your order is being processed and will be completed within 1-2 hours. Our Delivery  partner will call you when you order will be ready.</p>
                        <a href="{{ route('product.index')}}" class="btn btn-fill-out">Continue Shopping</a>
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


@endsection