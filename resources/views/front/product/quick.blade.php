<div class="ajax_quick_view">
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
                        |
                        @if($product->off != '')
                        <div class="on_sale">
                            <span>{{ $product->off }}% Off</span>
                        </div>
                        @endif
                        |
                        @if($product->point != 0)
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

                        @guest
                        <a href="javascript:void(0)" class="modal-login btn btn-fill-out btn-addtocart"><i class="icon-basket-loaded"></i> Add To Cart</a></a>
                        @else
                        <button data-id="{{ $product->id }}" class="add-cart btn btn-fill-out btn-addtocart" ><i class="icon-basket-loaded"></i> Add To Cart</button>
                        @endguest
                        <a class="add_wishlist add-wishlist" href="javascript:void(0)" data-id="{{ $product->id }}"><i class="icon-heart"></i></a>
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


