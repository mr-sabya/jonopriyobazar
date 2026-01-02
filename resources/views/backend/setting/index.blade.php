@extends('layouts.back')

@section('title', 'Setting')



@section('content')
<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form action="{{ route('admin.setting.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>Website</strong> Setting </h2>
                            </div>
                            <div class="body">

                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <div class="form-group form-float">
                                            <label for="website_name">Website Title</label>
                                            <input type="text" class="form-control" placeholder="Website Title" id="website_name" name="website_name" value="{{ $setting->website_name }}">
                                            @if ($errors->has('website_name'))
                                            <span id="title_error" style="color: red">{{ $errors->first('website_name') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group form-float">
                                            <label for="tagline">Website Tagline</label>
                                            <input type="text" class="form-control" placeholder="Website tagline" id="tagline" name="tagline" value="{{ $setting->tagline }}">
                                            @if ($errors->has('tagline'))
                                            <span id="title_error" style="color: red">{{ $errors->first('tagline') }}</span>
                                            @endif
                                        </div>
                                    </div>



                                    
                                    <div class="col-lg-6">
                                        <div class="form-group form-float">
                                            <label for="logo">Logo</label>
                                            <input type="file" class="setting-image" name="logo" id="logo" data-max-file-size="200K"  @if($setting->logo != null) data-default-file="{{ url('upload/images', $setting->logo)}}" @endif>
                                            <small>Image size must be 128px X 70px</small><br>
                                            @if ($errors->has('logo'))
                                            <span id="image_error" style="color: red">{{ $errors->first('logo') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group form-float">
                                            <label for="footer_logo">Footer Logo</label>
                                            <input type="file" class="setting-image" name="footer_logo" id="footer_logo" data-max-file-size="200K"  @if($setting->footer_logo != null) data-default-file="{{ url('upload/images', $setting->footer_logo)}}" @endif>
                                            <small>Image size must be 128px X 70px</small><br>
                                            @if ($errors->has('footer_logo'))
                                            <span id="image_error" style="color: red">{{ $errors->first('footer_logo') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group form-float">
                                            <label for="invoice_logo">Invoice Logo</label>
                                            <input type="file" class="setting-image" name="invoice_logo" id="invoice_logo" data-max-file-size="200K"  @if($setting->invoice_logo != null) data-default-file="{{ url('upload/images', $setting->invoice_logo)}}" @endif>
                                            <small>Image size must be 128px X 70px</small><br>
                                            @if ($errors->has('invoice_logo'))
                                            <span id="image_error" style="color: red">{{ $errors->first('invoice_logo') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group form-float">
                                            <label for="favicon">Favicon</label>
                                            <input type="file" class="setting-image" name="favicon" id="favicon" data-max-file-size="200K"  @if($setting->favicon != null) data-default-file="{{ url('upload/images', $setting->favicon)}}" @endif>
                                            <small>Image size must be 30px X 30px</small><br>
                                            @if ($errors->has('favicon'))
                                            <span id="image_error" style="color: red">{{ $errors->first('favicon') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group form-float">
                                            <label for="refer_percentage">Refer Percentage (%)</label>
                                            <input type="text" class="form-control" name="refer_percentage" id="refer_percentage" placeholder="2" value="{{ $setting->refer_percentage }}">
                                            @if ($errors->has('refer_percentage'))
                                            <span id="image_error" style="color: red">{{ $errors->first('refer_percentage') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group form-float">
                                            <label for="min_refer">Minimum Refer</label>
                                            <input type="text" class="form-control" name="min_refer" id="min_refer" placeholder="10" value="{{ $setting->min_refer }}">
                                            @if ($errors->has('min_refer'))
                                            <span id="image_error" style="color: red">{{ $errors->first('min_refer') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group form-float">
                                            <label for="dev_percentage">Developer Percentage (%)</label>
                                            <input type="text" class="form-control" name="dev_percentage" id="dev_percentage" placeholder="2" value="{{ $setting->dev_percentage }}">
                                            @if ($errors->has('dev_percentage'))
                                            <span id="image_error" style="color: red">{{ $errors->first('dev_percentage') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group form-float">
                                            <label for="marketing_percentage">Marketing Percentage (%)</label>
                                            <input type="text" class="form-control" name="marketing_percentage" id="marketing_percentage" placeholder="2" value="{{ $setting->marketing_percentage }}">
                                            @if ($errors->has('marketing_percentage'))
                                            <span id="image_error" style="color: red">{{ $errors->first('marketing_percentage') }}</span>
                                            @endif
                                        </div>
                                    </div>





                                    <div class="col-lg-12">
                                        <div class="form-group form-float">
                                            <label for="copyright">Copyright Text</label>
                                            <textarea class="form-control" name="copyright" id="copyright" placeholder="All Copyright © Jonopriyobazar">{{ $setting->copyright }}</textarea>
                                            @if ($errors->has('copyright'))
                                            <span id="link_error" style="color: red">{{ $errors->first('copyright') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>Other</strong> Page </h2>
                            </div>
                            <div class="body">

                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <div class="form-group form-float">
                                            <label for="terms">Terms and Conditions</label>
                                            <textarea class="form-control" name="terms" id="terms">{{ $setting->terms }}</textarea>
                                            @if ($errors->has('terms'))
                                            <span id="title_error" style="color: red">{{ $errors->first('terms') }}</span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="col-lg-12">
                                        <div class="form-group form-float">
                                            <label for="privacy">Privacy Policy</label>
                                            <textarea class="form-control" name="privacy" id="privacy">{{ $setting->privacy }}</textarea>
                                            @if ($errors->has('privacy'))
                                            <span id="title_error" style="color: red">{{ $errors->first('privacy') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group form-float">
                                            <label for="refer">Refer Policy</label>
                                            <textarea class="form-control" name="refer" id="refer">{{ $setting->refer }}</textarea>
                                            @if ($errors->has('refer'))
                                            <span id="title_error" style="color: red">{{ $errors->first('refer') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group form-float">
                                            <label for="refund">Refund Policy</label>
                                            <textarea class="form-control" name="refund" id="refund">{{ $setting->refund }}</textarea>
                                            @if ($errors->has('refund'))
                                            <span id="title_error" style="color: red">{{ $errors->first('refund') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    
                                    
                                </div>

                                
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>About</strong> Page </h2>
                            </div>
                            <div class="body">

                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <div class="form-group form-float">
                                            <label for="about_1">Section 1</label>
                                            <textarea class="form-control" name="about_1" id="about_1">{{ $setting->about_1 }}</textarea>
                                            @if ($errors->has('about_1'))
                                            <span id="title_error" style="color: red">{{ $errors->first('about_1') }}</span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="col-lg-12">
                                        <div class="form-group form-float">
                                            <label for="about_2">Section 2</label>
                                            <textarea class="form-control" name="about_2" id="about_2">{{ $setting->about_2 }}</textarea>
                                            @if ($errors->has('about_2'))
                                            <span id="title_error" style="color: red">{{ $errors->first('about_2') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    

                                    
                                    
                                </div>

                                
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>Website</strong> SEO </h2>
                            </div>
                            <div class="body">

                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <div class="form-group form-float">
                                            <label for="meta_desc">Meta Description</label>
                                            <textarea class="form-control" name="meta_desc" id="meta_desc">{{ $setting->meta_desc }}</textarea>
                                            @if ($errors->has('meta_desc'))
                                            <span id="title_error" style="color: red">{{ $errors->first('meta_desc') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group form-float">
                                            <label for="tags">Tags</label>
                                            <input type="text" class="form-control" placeholder="Website tags" id="tags" name="tags" value="{{ $setting->tags }}">
                                            @if ($errors->has('tags'))
                                            <span id="title_error" style="color: red">{{ $errors->first('tags') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group form-float">
                                            <label for="og_image">Facebook Og Image</label>
                                            <input type="file" class="setting-image" name="og_image" id="og_image" data-max-file-size="200K"  @if($setting->og_image != null) data-default-file="{{ url('upload/images', $setting->og_image)}}" @endif>
                                            <small>Image size must be 128px X 70px</small><br>
                                            @if ($errors->has('og_image'))
                                            <span id="image_error" style="color: red">{{ $errors->first('og_image') }}</span>
                                            @endif
                                        </div>
                                    </div>




                                    
                                </div>

                                <button type="submit" class="btn btn-primary waves-effect">Save</button>

                            </div>
                        </div>
                    </div>
                </div>
            </form>

            
        </div>
        
    </div>
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


    $('.setting-image').dropify();


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

    $('#terms').summernote({
        height: 300,
        focus: false,
    });
    
    $('#privacy').summernote({
        height: 300,
        focus: false,
    });

    $('#refund').summernote({
        height: 300,
        focus: false,
    });

    $('#refer').summernote({
        height: 300,
        focus: false,
    });

    $('#about_1').summernote({
        height: 300,
        focus: false,
    });

    $('#about_2').summernote({
        height: 300,
        focus: false,
    });


</script>

@endsection
