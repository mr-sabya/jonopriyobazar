@extends('layouts.back')

@section('title', 'Edit Product')



@section('content')
<div class="container-fluid">
    <!-- Exportable Table -->
    <form action="{{ route('admin.products.update', $product->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row clearfix">
            <div class="col-lg-8">
                <div class="card">

                    <div class="header">
                        <h2><strong>Product</strong> Title </h2>
                    </div>
                    <div class="body">

                        <div class="form-row">
                            <div class="col-lg-12">
                                <div class="form-group form-float">
                                    <label for="name">Title<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" placeholder="Product Title" id="name" name="name" value="{{ $product->name }}">
                                    @if ($errors->has('name'))
                                    <span id="title_error" style="color: red">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group form-float">
                                    <label for="slug">Slug<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" placeholder="slug" id="slug" name="slug" value="{{ $product->slug }}">
                                    @if ($errors->has('slug'))
                                    <span id="slug_error" style="color: red">{{ $errors->first('slug') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group form-float">
                                    <label for="image">Image<span style="color: red">*</span></label>
                                    <input type="file" name="image" id="image" data-max-file-size="300K" data-height="360" @if($product->image != null)data-default-file="{{ url('upload/images', $product->image)}}" @endif>
                                    <small>Image size must be 540px X 600px</small><br>
                                    @if ($errors->has('image'))
                                    <span id="slug_error" style="color: red">{{ $errors->first('image') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group form-float">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" id="description">{{ $product->description }}</textarea>
                                    @if ($errors->has('description'))
                                    <span id="slug_error" style="color: red">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary waves-effect">Save</button>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">

                            <div class="header">
                                <h2><strong>Product</strong> Pricing </h2>
                            </div>
                            <div class="body">

                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <div class="form-group form-float">
                                            <label for="quantity">Quantity/Pieces<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" placeholder="1 kg / 100 pcs" id="quantity" name="quantity" value="{{ $product->quantity }}">
                                            @if ($errors->has('quantity'))
                                            <span id="title_error" style="color: red">{{ $errors->first('quantity') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group form-float">
                                            <label for="sale_price">Sale Price<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" placeholder="100" id="sale_price" name="sale_price" value="{{ $product->sale_price }}">
                                            @if ($errors->has('sale_price'))
                                            <span id="title_error" style="color: red">{{ $errors->first('sale_price') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group form-float">
                                            <label for="actual_price">Actual Price</label>
                                            <input type="text" class="form-control" placeholder="100" id="actual_price" name="actual_price" value="{{ $product->actual_price }}">
                                            @if ($errors->has('actual_price'))
                                            <span id="title_error" style="color: red">{{ $errors->first('actual_price') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group form-float">
                                            <label for="off">% Off</label>
                                            <input type="text" class="form-control" placeholder="10" id="off" name="off" value="{{ $product->off }}">
                                            @if ($errors->has('off'))
                                            <span id="title_error" style="color: red">{{ $errors->first('off') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group form-float">
                                            <label for="point">Point</label>
                                            <input type="text" class="form-control" placeholder="10" id="point" name="point" value="{{ $product->point }}">
                                            @if ($errors->has('point'))
                                            <span id="title_error" style="color: red">{{ $errors->first('point') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group form-float">
                                            <div class="checkbox">
                                                <input id="is_percentage" type="checkbox" name="is_percentage" value="1" {{ $product->is_percentage == 1 ? 'checked' : '' }}>
                                                <label for="is_percentage">Partner Percentage</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group form-float">
                                            <div class="checkbox">
                                                <input id="is_stock" type="checkbox" name="is_stock" value="1" {{ $product->is_stock == 1 ? 'checked' : '' }}>
                                                <label for="is_stock">In Stock</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>Product</strong> Category </h2>
                            </div>
                            <div class="body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group form-float">
                                            <label for="category_id">Category<span style="color: red">*</span></label>
                                            
                                            @if ($errors->has('category_id'))
                                            <span id="slug_error" style="color: red">{{ $errors->first('category_id') }}</span>
                                            @endif
                                        </div>
                                        @foreach($categories as $parent)
                                        <?php
                                        $product_categories = $product->categories;
                                        $check = '';
                                        foreach ($product_categories as $product_cat) {
                                            if($product_cat->slug == $parent->slug){
                                                $check = 'check';
                                            }
                                        }
                                        ?>
                                        
                                        
                                        <div class="checkbox">
                                            <input id="parent_{{ $parent->id }}" type="checkbox" name="category[]" value="{{ $parent->id }}" {{ $check == 'check' ? 'checked' : ''}}>
                                            <label for="parent_{{ $parent->id }}">{{ $parent->name }}</label>
                                        </div>
                                        @foreach($parent->sub as $sub)

                                        <?php
                                        $check = '';
                                        foreach ($product_categories as $product_cat) {
                                            if($product_cat->slug == $sub->slug){
                                                $check = 'check';
                                            }
                                        }
                                        ?>

                                        <div class="ml-3">
                                            <div class="checkbox">
                                                <input id="sub_{{ $sub->id }}" type="checkbox" name="category[]" value="{{ $sub->id }}" {{ $check == 'check' ? 'checked' : ''}}>
                                                <label for="sub_{{ $sub->id }}">{{ $sub->name }}</label>
                                            </div>
                                        </div>
                                        @foreach($sub->sub as $subcat)
                                        <?php
                                        $check = '';
                                        foreach ($product_categories as $product_cat) {
                                            if($product_cat->slug == $subcat->slug){
                                                $check = 'check';
                                            }
                                        }
                                        ?>
                                        <div class="ml-5">
                                            <div class="checkbox">
                                                <input id="subcat_{{ $subcat->id }}" type="checkbox" name="category[]" value="{{ $subcat->id }}" {{ $check == 'check' ? 'checked' : ''}}>
                                                <label for="subcat_{{ $subcat->id }}">{{ $subcat->name }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </form>
    
</div>


@endsection

@section('scripts')
<!-- Dropify -->
<script src="{{ asset('backend/plugins/dropify/js/dropify.min.js') }}"></script>

<!-- Summernote -->
<script src="{{ asset('backend/plugins/summernote/dist/summernote.js') }}"></script>

<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#description').summernote({
        height: 300,
        focus: false,
    });


    $('#icon').dropify();
    $('#image').dropify();

    $("#name").on('keyup blur', function() {
        var Text = $(this).val();
        Text = Text.toLowerCase();
        Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
        $("#slug").val(Text);
    });

    $('#name').keyup(function(e) {
        if ($(this).val() != '') {
            $('#title_error').html('');
            $('#slug_error').html('');
        }
    });

    $('#slug').keyup(function(e) {
        if ($(this).val() != '') {
            $('#slug_error').html('');
        }
    });

    var medium_id;

    $(document).on('click', '.delete', function() {
        medium_id = $(this).attr('id');
        $('#confirm_modal').modal('show');
    });



</script>
@include('backend.product.partials.script')

@endsection
