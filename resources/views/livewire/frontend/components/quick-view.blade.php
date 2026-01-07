<div wire:ignore.self class="modal fade" id="quickViewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-body p-4">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; right: 20px; top: 15px; z-index: 999;">
                    <span aria-hidden="true">&times;</span>
                </button>

                @if($product)
                <div class="ajax_quick_view">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 mb-3 mb-md-0">
                            <div class="product-image border rounded p-3 text-center bg-light">
                                <img src="{{ url('upload/images', $product->image) }}" class="img-fluid" style="max-height: 380px; object-fit: contain;">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="pr_detail text-left">
                                <h4 class="product_title font-weight-bold text-dark">{{ $product->name }}</h4>
                                <p class="text-muted mb-2">{{ $product->quantity }}</p>

                                <div class="product_price d-flex align-items-center mb-3">
                                    <h3 class="price text-danger mr-3 mb-0">৳{{ $product->sale_price }}</h3>
                                    @if($product->actual_price)
                                    <del class="text-muted mr-3">৳{{ $product->actual_price }}</del>
                                    @endif
                                    @if($product->off)
                                    <span class="badge badge-success">{{ $product->off }}% Off</span>
                                    @endif
                                </div>

                                <div class="pr_desc"></div>

                                <hr />

                                <div class="cart_extra d-flex align-items-center">
                                    <div class="quantity-control d-flex align-items-center mr-3 border rounded px-1" style="background: #f8f9fa;">
                                        <button wire:click="decrement" class="btn btn-sm btn-link text-dark font-weight-bold" style="text-decoration:none;">-</button>
                                        <input type="text" value="{{ $quantity }}" readonly class="form-control form-control-sm text-center border-0 bg-transparent" style="width: 45px; font-weight:bold; font-size: 16px;">
                                        <button wire:click="increment" class="btn btn-sm btn-link text-dark font-weight-bold" style="text-decoration:none;">+</button>
                                    </div>

                                    <div class="flex-grow-1">
                                        <button wire:click="addToCart" class="btn btn-block bg-success text-white font-weight-bold py-2 shadow-sm mt-3">
                                            <span wire:loading.remove wire:target="addToCart">
                                                <i class="icon-basket-loaded mr-1"></i> ADD TO BAG
                                            </span>
                                            <span wire:loading wire:target="addToCart">ADDING...</span>
                                        </button>
                                    </div>
                                </div>
                                <hr />
                                <ul class="list-unstyled d-flex small text-muted p-0 m-0">
                                    <li class="mr-4"><i class="fas fa-truck text-success mr-1"></i> 1 hour Delivery</li>
                                    <li><i class="fas fa-money-bill-wave text-success mr-1"></i> Cash on Delivery</li>
                                </ul>
                            </div>
                        </div>



                    </div>
                    @if($product->description)
                    <div class="text-muted small mt-3 border p-2">
                        {!! $product->clean_description !!}
                    </div>
                    @endif
                </div>
                @else
                <div class="text-center p-5">
                    <div class="spinner-border text-danger" role="status"></div>
                    <p class="mt-2">Loading Product Details...</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>