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


$(document).on('click', '.add-to-cart', function() {
    var id = $(this).attr('data-id');
    $.ajax({
        url: "/add-cart/"+id,
        dataType: "json",
        success: function (data) {
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

// view add to cart
$(document).on('click', '.add-cart', function(){

    var id = $(this).attr('data-id');

    $.ajax({
        url: "/add-to-cart",
        method: "GET",
        data: {
            product_id: $('#product_'+id).val(),
            quantity: $('#get_quantity_'+id).val(),
        },

        dataType: "json",
        success: function (data) {
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

// get cart items
$(document).on('click', '#get_cart', function() {
    fetchCart();
});


//cart remove item
$(document).on('click', '.item_remove', function () {
    var id = $(this).attr('id');

    var item_price = $('#item_price_'+id).html();
    var cart_price = $('#cart_price').html();

    var quantity = $('#quantity_'+id).html();
    var c_quantity = $('#view_cart_top').html();
    var f_quantity = parseInt(c_quantity) - parseInt(quantity);

    $('#view_cart_top').html(parseInt(f_quantity));
    $('#view_cart').html(parseInt(f_quantity));


    $(this).closest('tr').remove();

    $.ajax({
        url: "/cart/delete/"+id,
        dataType: "json",
        method: "DELETE",
        success: function (data) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'warning',
                title: 'Item delete from cart',
                showConfirmButton: false,
                timer: 1500
            });


            var current_total = parseInt(cart_price) - parseInt(item_price);
            $('#cart_price').html(parseInt(current_total));
            $('#view_subtotal').html(parseInt(current_total));

        }
    });
});


function totalCount() {
    var total = $('#view_cart_top').html();
    var final_total = parseInt(total) +1;
    $('#view_cart_top').html(parseInt(final_total));
    $('#view_cart').html(parseInt(final_total));
}


 //cart increment
 $(document).on('click', '.increment', function () {


    var cart_id = $(this).attr('data-id');
    var price = $(this).attr('data-price');
    var actual_price = $('#product_actual_price_'+cart_id).html();

    var quantity = $('#quantity_'+cart_id).html();

    var final_quantity = parseInt(quantity) + 1;

    $('#quantity_'+cart_id).html(parseInt(final_quantity));
    $('#sub_quantity_'+cart_id).html(parseInt(final_quantity));

    var total = parseInt(final_quantity) * parseInt(price);
    $('#item_price_'+cart_id).html(parseInt(total));

    var actual_total = parseInt(actual_price) * parseInt(final_quantity);
    $('#actual_price_'+cart_id).html(parseInt(actual_total));


    totalCount();


    $.ajax({
        url: "/cart/increment/"+ cart_id,
        dataType: "json",
        success: function (data) {
            $('#cart_price').html(data.carts)
            $('#view_subtotal').html(data.carts)

        }
    });
});


 function totalCountDecrement() {
    var total = $('#view_cart_top').html();
    var final_total = parseInt(total) - 1;
    $('#view_cart_top').html(parseInt(final_total));
    $('#view_cart').html(parseInt(final_total));
}

//cart decrement
$(document).on('click', '.decrement', function () {

    var cart_id = $(this).attr('data-id');
    var quantity = $('#quantity_'+cart_id).html();
    var actual_price = $('#product_actual_price_'+cart_id).html();

    if(quantity >1){
        var cart_id = $(this).attr('data-id');
        var price = $(this).attr('data-price');


        var final_quantity = parseInt(quantity) - 1;

        $('#quantity_'+cart_id).html(parseInt(final_quantity));
        $('#sub_quantity_'+cart_id).html(parseInt(final_quantity));

        var total = parseInt(final_quantity) * parseInt(price);
        $('#item_price_'+cart_id).html(parseInt(total));

        var actual_total = parseInt(actual_price) * parseInt(final_quantity);
        $('#actual_price_'+cart_id).html(parseInt(actual_total));

        totalCountDecrement();

        $.ajax({
            url: "/cart/decrement/"+ cart_id,
            dataType: "json",
            success: function (data) {
                $('#cart_price').html(data.carts)
                $('#view_subtotal').html(data.carts)
            }
        });
    }



});


// add to wishlist
$(document).on('click', '.add-wishlist', function(){

    var id = $(this).attr('data-id');

    $.ajax({
        url: "/add-wishlist/"+id,
        method: "GET",
        dataType: "json",
        success: function (data) {
            if(data.success){
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Item added to wishlist',
                    showConfirmButton: false,
                    timer: 1500
                })

                var curent = $('#wishlist_count').html();
                $('#wishlist_count').html(parseInt(curent) + 1);
            }

            if(data.error){
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'warning',
                    title: data.error,
                    showConfirmButton: false,
                    timer: 1500
                })
            }
            

        }
    });

});