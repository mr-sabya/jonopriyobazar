@extends('layouts.front')

@section('title')
Order Canceled
@endsection

@section('content')
<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="mb-3">
                        <a href="{{ route('user.profile')}}"><i class="fas fa-arrow-left"></i> Go BacK</a>
                    </div>
                    <div class="text-center order_complete">
                        <i class="fas fa-check-circle"></i>
                        <div class="heading_s1">
                            <h3>Your order is Canceled!</h3>
                        </div>
                        
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