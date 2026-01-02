@extends('layouts.back')

@section('title', 'Add Category')



@section('content')
<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">

                <div class="header">
                    <h2><strong>Category</strong> Add </h2>
                </div>
                <div class="body">
                    <form action="{{ route('admin.category.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="col-lg-6">
                                <div class="form-group form-float">
                                    <label for="name">Category</label>
                                    <input type="text" class="form-control" placeholder="Category" id="name" name="name" title="Please enter category">
                                    @if ($errors->has('name'))
                                    <span id="title_error" style="color: red">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group form-float">
                                    <label for="slug">Slug</label>
                                    <input type="text" class="form-control" placeholder="slug" id="slug" name="slug" title="Please enter slug">
                                    @if ($errors->has('slug'))
                                    <span id="slug_error" style="color: red">{{ $errors->first('slug') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group form-float">
                                    <label for="icon">Icon</label>
                                    <input type="file" name="icon" id="icon" data-max-file-size="200K" data-height="190">
                                    <small>Image size must be 40px X 40px</small><br>
                                    @if ($errors->has('icon'))
                                    <span id="image_error" style="color: red">{{ $errors->first('icon') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group form-float">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" id="image" data-max-file-size="200K" data-height="190">
                                    <small>Image size must be 540px X 600px</small><br>
                                    @if ($errors->has('image'))
                                    <span id="slug_error" style="color: red">{{ $errors->first('image') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group form-float">
                                    <label for="p_id">Parent</label>
                                    <select class="form-control" name="p_id" id="p_id">
                                        <option value="0">None</option>
                                        @foreach($categories as $parent)
                                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                        @foreach($parent->sub as $sub)
                                        <option value="{{ $sub->id }}">-- {{ $sub->name }}</option>
                                        @endforeach
                                        @endforeach
                                    </select>
                                    @if ($errors->has('p_id'))
                                    <span id="slug_error" style="color: red">{{ $errors->first('p_id') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group form-float">
                                    <label for="p_id">Home</label>
                                    <div class="checkbox">
                                        <input id="is_home" type="checkbox" name="is_home" value="1">
                                        <label for="is_home">This category will appear at Home</label>
                                    </div>
                                    @if ($errors->has('p_id'))
                                    <span id="slug_error" style="color: red">{{ $errors->first('p_id') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary waves-effect">Save</button>

                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>


@endsection

@section('scripts')
<!-- Dropify -->
<script src="{{ asset('backend/plugins/dropify/js/dropify.min.js') }}"></script>

<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
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

@endsection
