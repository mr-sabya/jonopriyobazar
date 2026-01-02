@extends('layouts.back')

@section('title', 'Add Banner')



@section('content')
<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-6">
            <div class="card">

                <div class="header">
                    <h2><strong>Banner</strong> Add </h2>
                </div>
                <div class="body">
                    <form action="{{ route('admin.banner.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="col-lg-12">
                                <div class="form-group form-float">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" placeholder="Banner Title" id="title" name="title" title="Please enter banner title">
                                    @if ($errors->has('title'))
                                    <span id="title_error" style="color: red">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>
                            </div>

                            
                            <div class="col-lg-12">
                                <div class="form-group form-float">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" id="image" data-height="250">
                                    <small>Image size must be 825px X 550px</small><br>
                                    @if ($errors->has('image'))
                                    <span id="image_error" style="color: red">{{ $errors->first('image') }}</span>
                                    @endif
                                </div>
                            </div>
                            

                            <div class="col-lg-12">
                                <div class="form-group form-float">
                                    <label for="link">Banner Link</label>
                                    <input id="link" type="text" class="form-control" name="link" placeholder="Banner link here">
                                    @if ($errors->has('link'))
                                    <span id="link_error" style="color: red">{{ $errors->first('link') }}</span>
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


    $('#image').dropify();


    $('#title').keyup(function(e) {
        if ($(this).val() != '') {
            $('#title_error').html('');
        }
    });

    $('#link').keyup(function(e) {
        if ($(this).val() != '') {
            $('#link_error').html('');
        }
    });

    $('#image').change(function(e) {
        if ($(this).val() != '') {
            $('#image_error').html('');
        }
    });


</script>

@endsection
