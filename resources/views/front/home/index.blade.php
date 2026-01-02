@extends('layouts.front')

@section('title', 'Home')

@section('content')

<!-- END MAIN CONTENT -->
<div class="main_content">

    <div class="mt-4 staggered-animation-wrap">
        <div class="custom-container">
            <div class="row">
                <div class="col-lg-9 offset-lg-3">
                    <div class="banner_section shop_el_slider">
                        <div id="carouselExampleControls" class="carousel slide carousel-fade light_arrow" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($banners as $banner)
                                <div class="carousel-item {{ $loop->index ==1 ? 'active' : ''}} background_bg" data-img-src="{{ url('upload/images', $banner->image) }}">
                                    <div class="banner_slide_content banner_content_inner">
                                        <div class="col-lg-7 col-10">
                                            <div class="banner_content3 overflow-hidden">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <ol class="carousel-indicators indicators_style3">
                                @foreach($banners as $banner)
                                <li data-target="#carouselExampleControls" data-slide-to="0" class="{{ $loop->index ==1 ? 'active' : ''}}"></li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- START SECTION SHOP -->
    <div class="section small_pt pb-0">
        <div class="custom-container">
            <div class="row">

                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="heading_tab_header">
                                <div class="heading_s2">
                                    <h4>Our Product Categories</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        @foreach($categories as $category)
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="category-wrap">
                                <a href="{{ route('category.sub', $category->slug)}}">
                                    <div class="category-img">
                                        @if($category->icon == null)
                                        <img src="{{ url('frontend/images/demo.png')}}" alt="demo">
                                        @else
                                        <img src="{{ url('upload/images', $category->icon) }}" alt="el_img2">
                                        @endif
                                    </div>
                                    <div class="category-info">
                                        <h6 class="category-title">{{ $category->name }}</h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
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
                        <div class="product">
                            <div class="product_img">

                                <img src="{{ url('upload/images', $flash->image) }}" alt="el_img2">

                                <div class="product_action_box">
                                    <ul class="list_none pr_action_btn">
                                        <li><a href="{{ route('product.quick', $flash->id)}}" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                        <li><a href="javascript:void(0)" class="add-wishlist" data-id="{{ $flash->id }}"><i class="icon-heart"></i></a></li>
                                    </ul>
                                </div>
                                @if($flash->off != null)
                                <div class="off">
                                    <p>{{ $flash->off }} % Off</p>
                                </div>
                                @endif
                                @if($flash->point != 0)
                                <div class="point">
                                    <p><i class="fas fa-coins"></i> {{ $flash->point }}</p>
                                </div>
                                @endif
                            </div>
                            <div class="product_info">
                                <h6 class="product_title text-center"><a href="{{ route('product.quick', $flash->id)}}" class="popup-ajax">{{ $flash->name }}</a></h6>
                                <div class="product_price text-center">
                                    <p class="quantity m-0 p-0">{{ $flash->quantity }}</p>
                                    <span class="price">৳{{ $flash->sale_price }}</span>
                                    @if($flash->actual_price != '')
                                    <del>৳{{ $flash->actual_price }}</del>
                                    @endif

                                </div>


                            </div>
                            <div class="cart">
                                @guest
                                <a href="javascript:void(0)" class="modal-login btn btn-cart w-100"><i class="icon-basket-loaded"></i> Add To Cart</a>
                                @else
                                <a href="javascript:void(0)" class="add-to-cart btn btn-cart w-100" data-id="{{ $flash->id }}"><i class="icon-basket-loaded"></i> Add To Cart</a>
                                @endguest
                            </div>
                        </div>

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
                                    <div class="product">
                                        <div class="product_img">

                                            <img src="{{ url('upload/images', $product->image) }}" alt="el_img2">
                                            
                                            <div class="product_action_box">
                                                <ul class="list_none pr_action_btn">
                                                    <li><a href="{{ route('product.quick', $product->id)}}" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                    <li><a href="javascript:void(0)" class="add-wishlist" data-id="{{ $product->id }}"><i class="icon-heart"></i></a></li>
                                                </ul>
                                            </div>
                                            @if($product->off != null)
                                            <div class="off">
                                                <p>{{ $product->off }} % Off</p>
                                            </div>
                                            @endif
                                            @if($product->point != 0)
                                            <div class="point">
                                                <p><i class="fas fa-coins"></i> {{ $product->point }}</p>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="product_info">
                                            <h6 class="product_title text-center"><a href="{{ route('product.quick', $product->id)}}" class="popup-ajax">{{ $product->name }}</a></h6>
                                            <div class="product_price text-center">
                                                <p class="quantity m-0 p-0">{{ $product->quantity }}</p>
                                                <span class="price">৳{{ $product->sale_price }}</span>
                                                @if($product->actual_price != '')
                                                <del>৳{{ $product->actual_price }}</del>
                                                @endif

                                            </div>


                                        </div>
                                        <div class="cart">
                                            @guest
                                            <a href="javascript:void(0)" class="modal-login btn btn-cart w-100"><i class="icon-basket-loaded"></i> Add To Cart</a>
                                            @else
                                            <a href="javascript:void(0)" class="add-to-cart btn btn-cart w-100" data-id="{{ $product->id }}"><i class="icon-basket-loaded"></i> Add To Cart</a>
                                            @endguest
                                        </div>
                                    </div>

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

