@extends('front.layouts.app')

@section('title', 'Home')

@section('content')

<!-- END MAIN CONTENT -->
<div class="main_content">

    <!-- banner start -->
    <livewire:frontend.home.banner />
    <!-- banner start -->

    <!-- START SECTION SHOP -->
    <livewire:frontend.home.categories />
    <!-- END SECTION SHOP -->



    @if(count($flash_products)>0)
    <!-- START SECTION SHOP -->
    <div class="section pt-0 pb-0">
        <div class="custom-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading_tab_header">
                        <div class="heading_s2">
                            <h4>Flash Sale</h4>
                        </div>
                        <a href="{{ route('category.sub', 'flash-sale')}}">Show All</a>
                    </div>
                </div>
            </div>
            <div class="row">

                @foreach($flash_products as $flash)
                <div class="col-lg-2 col-2">
                    <div class="item">
                        <livewire:frontend.components.product productId="{{ $flash->id }}" />
                    </div>
                </div>

                @endforeach

            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->
    @endif

    <!-- START SECTION SHOP -->
    <div class="section small_pt small_pb">
        <div class="custom-container">
            <div class="row">
                <div class="col-xl-3 d-none d-xl-block">
                    <div class="sale-banner">
                        <a class="hover_effect1" href="#">
                            <img src="{{ url('frontend/images/side-ban.png') }}" alt="shop_banner_img10">
                        </a>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="row">
                        <div class="col-12">
                            <div class="heading_tab_header">
                                <div class="heading_s2">
                                    <h4>Trending products</h4>
                                </div>
                                <div class="view_all">
                                    <a href="{{ route('product.index')}}" class="text_default"><i class="linearicons-power"></i> <span>View All</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="product_slider carousel_slider owl-carousel owl-theme dot_style1" data-loop="true" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>
                                @foreach($products as $product)
                                <div class="item">
                                     <livewire:frontend.components.product productId="{{ $product->id }}" />

                                </div>

                                @endforeach
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