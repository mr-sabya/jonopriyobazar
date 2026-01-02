@extends('layouts.front')

@section('title')
{{ $category->name }}
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
                        @if(!count($products)>0)
                        <div class="col-lg-12 text-center">
                            <h2>No Product Found</h2>
                            <a href="{{ route('product.index')}}" class="btn btn-success mt-2"><i class="fas fa-store"></i> Go to Shop</a>
                        </div>
                        @endif
                    </div>
                    <div class="row load-more mt-5">
                        <div class="col-12 text-center">
                            <div class="load">
                                <form id="category_form" method="post" style="display: none;">
                                    @csrf
                                    <input type="text" name="category_id" value="{{ $category->id }}">
                                </form>
                                @if(count($products)>0)
                                <button class="btn btn-dark" id="load_more">Load More</button>
                                @endif
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


        function lodeMoreData(page, query) {
            $.ajax({
                url: '/fetch-category-product?page=' + page,
                data:query,
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

            var $form = $("#category_form");
            var query = getFormData($form);
            page++;
            lodeMoreData(page, query);
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