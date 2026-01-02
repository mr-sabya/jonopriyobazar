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
                        @include('front.product.partials.list')
                    </div>
                    <div class="row load-more mt-5">
                        <div class="col-12 text-center">
                            <div class="load">
                                <button class="btn btn-dark" id="load_more">Load More</button>
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