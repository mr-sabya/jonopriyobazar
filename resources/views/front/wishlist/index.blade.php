@extends('front.layouts.app')

@section('title', 'Wishlist')

@section('content')
<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive wishlist_table">
                        <table class="table" id="wishlist_table">
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">&nbsp;</th>
                                    <th class="product-name">Product</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-stock-status">Stock Status</th>
                                    <th class="product-add-to-cart"></th>
                                    <th class="product-remove">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($lists->count()>0)
                                @foreach($lists as $list)
                                <tr>
                                    <td class="product-thumbnail">
                                        <img src="{{ url('upload/images', $list->product['image'])}}" alt="product1">
                                    </td>
                                    <td class="product-name" data-title="Product">{{ $list->product['name'] }} - {{ $list->product['quantity'] }}</td>
                                    <td class="product-price" data-title="Price">
                                        ৳{{ $list->product['sale_price'] }} 
                                        @if($list->product['actual_price'] != null)
                                        <del>{{ $list->product['actual_price']}}</del>
                                        @endif
                                    </td>
                                    <td class="product-stock-status" data-title="Stock Status"><span class="badge badge-pill badge-success">In Stock</span></td>
                                    <td class="product-add-to-cart">
                                        <a href="javascript:void(0)" class="add btn btn-fill-out" data-id="{{ $list->id }}"><i class="icon-basket-loaded"></i> <span id="add_btn_{{ $list->id}}">Add to Cart</span></a>
                                    </td>
                                    <td class="product-remove" data-title="Remove">
                                        <a href="javascript:void(0)" data-id="{{ $list->id }}" class="remove"><i class="ti-close"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6" class="text-center">
                                        Whish list is Empty
                                    </td>
                                </tr>
                                @endif
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT -->

@endsection

@section('script')
<script>

    $(document).on('click', '.remove', function () {
        var id = $(this).attr('data-id');

        var this_row = $(this);

        $.ajax({
            url: "/wishlist/remove/"+id,
            dataType: "json",
            method: "DELETE",
            success: function (data) {
                if(data.success){
                    
                    this_row.closest('tr').remove();

                    var rowCount = $('#wishlist_table tbody tr').length;
                    if(rowCount == 0){
                        $('#wishlist_table').append('<tr><td colspan="6" class="text-center"> Whish list is Empty</td></tr>');
                    }
                    
                    var curent = $('#wishlist_count').html();
                    $('#wishlist_count').html(parseInt(curent) - 1);
                    
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: data.success,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
    });

    function fetchCart() {
        $.ajax({
            url:"/fetch-cart",
            success:function(data)
            {
                if(data != ''){
                    $('#cart_product').html('');
                    $('#cart_product').append(data);
                }else{
                    $('#cart_product').html('<span style="font-size: 48px;color: #ddd;text-align: center;display: block;margin-top: 200px; line-height: 60px;">Nothing to show</span>');
                }

            }
        });
    }



    $(document).on('click', '.add', function() {
        var id = $(this).attr('data-id');
        var this_row = $(this);
        $.ajax({
            url: "/wishlist/add-cart/"+id,
            dataType: "json",
            beforeSend: function(){
                $('#add_btn_'+id).html('Adding....');
            },

            success: function (data) {
                this_row.closest('tr').remove();

                var rowCount = $('#wishlist_table tbody tr').length;
                if(rowCount == 0){
                    $('#wishlist_table').append('<tr><td colspan="6" class="text-center"> Whish list is Empty</td></tr>');
                }
                    
                var curent = $('#wishlist_count').html();
                $('#wishlist_count').html(parseInt(curent) - 1);

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Item added to cart',
                    showConfirmButton: false,
                    timer: 1500
                })

                fetchCart();

                $('#view_cart').html(data.items);
                $('#view_cart_top').html(data.items);
                $('#view_subtotal').html(data.total);
                $('#cart_price').html(data.total);


            }
        });
    });

</script>
@endsection