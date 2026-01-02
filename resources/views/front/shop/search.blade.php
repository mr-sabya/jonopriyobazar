@extends('layouts.front')

@section('title')
Shop
@endsection

@section('content')
<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="custom-container">
            <div class="row">
                <div class="col-12">

                    <div class="row" id="product_data">

                        @if($products->count()>0)
                        @foreach($products as $product)
                        <div class="col-lg-2 col-md-6 col-sm-6 col-6">
                            <div class="product_wrap">
                                <div class="product_img">
                                    <a href="shop-product-detail.html">
                                        <img src="{{ url('upload/images', $product->image) }}" alt="el_img2">
                                    </a>
                                    <div class="product_action_box">
                                        <ul class="list_none pr_action_btn">
                                            <li><a href="javascript:void(0)" data-toggle="modal" data-target="#product_pop_{{ $product->id}}"><i class="icon-magnifier-add"></i></a></li>
                                            <li><a href="#"><i class="icon-heart"></i></a></li>
                                        </ul>
                                    </div>

                                    @if($product->off != null)
                                    <div class="off">
                                        <p>{{ $product->off }} % Off</p>
                                    </div>
                                    @endif
                                    @if($product->point != 0)
                                    <div class="point">
                                        <p>{{ $product->point }} Points</p>
                                    </div>
                                    @endif
                                </div>
                                <div class="product_info">
                                    <h6 class="product_title text-center"><a href="javascript:void(0)" data-toggle="modal" data-target="#product_pop_{{ $product->id}}">{{ $product->name }}</a></h6>
                                    <div class="product_price text-center">
                                        <p class="quantity m-0 p-0">{{ $product->quantity }}</p>
                                        <span class="price">৳{{ $product->sale_price }}</span>
                                        @if($product->actual_price != '')
                                        <del>৳{{ $product->actual_price }}</del>
                                        @endif

                                    </div>


                                </div>
                                <div class="cart">
                                    
                                    @if($product->is_stock == 1)
                                    @guest
                                    <a href="javascript:void(0)" class="modal-login btn btn-cart w-100"><i class="icon-basket-loaded"></i> Add To Cart</a>
                                    @else
                                    <a href="javascript:void(0)" class="add-to-cart btn btn-cart w-100" data-id="{{ $product->id }}"><i class="icon-basket-loaded"></i> Add To Cart</a>
                                    @endguest
                                    @else
                                    <a href="javascript:void(0)" class="disabled btn btn-cart w-100"><i class="icon-basket-loaded"></i> Stock Out</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="modal fade product-modal" id="product_pop_{{ $product->id}}" tabindex="-1" role="dialog" aria-modal="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"><i class="fa fa-times"></i></span>
                                        </button>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                                                <div class="product-image">
                                                    <div class="product_img_box">
                                                        <img id="product_img" src="{{ url('upload/images', $product->image) }}" data-zoom-image="{{ url('upload/images', $product->image) }}" alt="product_img1" />
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="pr_detail">
                                                    <div class="product_description">
                                                        <h4 class="product_title">{{ $product->name }}</h4>
                                                        <p>{{ $product->quantity }}</p>
                                                        <div class="product_price w-100">
                                                            <span class="price">৳{{ $product->sale_price }}</span>
                                                            @if($product->actual_price != null)
                                    <del>
                                        ৳{{ $product->actual_price }}
                                    </del>
                                    @endif
                                    
                                    @if($product->off != '')
                                    |
                                    <div class="on_sale">
                                        <span>{{ $product->off }}% Off</span>
                                    </div>
                                    @endif
                                    
                                    @if($product->point != 0)
                                    |
                                    <span><i class="fas fa-coins"></i> {{ $product->point }}</span>
                                    @endif
                                                        </div>

                                                        <div class="pr_desc">
                                                            {!! $product->description !!}
                                                        </div>


                                                    </div>
                                                    <hr />
                                                    <div class="cart_extra">

                                                        <input type="hidden" name="product_id" id="product_{{ $product->id }}" value="{{ $product->id}}">
                                                        <div class="cart-product-quantity">
                                                            <div class="quantity">
                                                                <input type="button" value="-" class="minus">
                                                                <input type="text" id="get_quantity_{{ $product->id}}" name="quantity" value="1" title="Qty" class="qty" size="4">
                                                                <input type="button" value="+" class="plus">
                                                            </div>
                                                        </div>

                                                        <div class="cart_btn">
@if($product->is_stock == 1)
                                                            @guest
                                                            <a href="javascript:void(0)" class="modal-login btn btn-fill-out btn-addtocart"><i class="icon-basket-loaded"></i> Add To Cart</a>
                                                            @else
                                                            <button data-id="{{ $product->id }}" class="add-cart btn btn-fill-out btn-addtocart" ><i class="icon-basket-loaded"></i> Add To Cart</button>
                                                            @endguest
                                                            @else
                                                            <a href="javascript:void(0)" class="disabled btn btn-cart w-100"><i class="icon-basket-loaded"></i> Stock Out</a>
                                                            @endif
                                                            <a class="add_wishlist" href="#"><i class="icon-heart"></i></a>
                                                        </div>


                                                    </div>
                                                    <hr />
                                                    <div class="footer-banner">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <ul>
                                                                    <li><i class=""></i> 1 hour Delivery</li>
                                                                    <li>Cash on Delivery</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else

                        <div class="col-lg-12 text-center">
                            <p class="text-center"> Sorry! No Products Found. Search again</p>
                            <a href="{{ route('product.index')}}" class="btn btn-fill-out">Go to Shop</a>
                        </div>
                        @endif


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
    $(document).ready(function(){


        function lodeMoreData(page) {
            $.ajax({
                url: '/shop/fetch-product?page=' + page,
                type: 'get',
                beforeSend: function() {
                    $("#load_more").html('Loading..');
                }
            })
            .done(function(data) {
                if (data == '') {
                    $("#load_more").html('no more product found');
                    return;
                }
                $("#load_more").html('Load More');
                $('#product_data').append(data);
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                console.log('Server not responding...');
            });

        }

        var page = 1;

        $('#load_more').click(function(event) {


            page++;
            lodeMoreData(page);
        });

        function getFormData($form){
            var unindexed_array = $form.serializeArray();
            var indexed_array = {};

            $.map(unindexed_array, function(n, i){
                indexed_array[n['name']] = n['value'];
            });

            return indexed_array;
        }
    });


    
</script>
@endsection