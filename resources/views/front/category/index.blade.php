@extends('front.layouts.app')


@section('title')

@if($category != '')
{{ $category->name }}
@else
All Category
@endif

@endsection

@section('content')
<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START SECTION SHOP -->
    <div class="section" style="margin: 50px 0 100px 0;">
        <div class="custom-container">
            <div class="row">
                <div class="col-12">

                    <div class="row justify-content-center">
                        @if($categories->count()>0)
                        @foreach($categories as $category)
                        <div class="col-lg-2 col-md-6 col-sm-6 col-6">
                            <a href="{{ route('category.sub', $category->slug)}}">
                                <div class="product_wrap text-center">
                                    <div class="category_image">
                                        @if($category->image == null)
                                        <img src="{{ url('frontend/images/demo.png')}}" alt="demo">
                                        @else
                                        <img src="{{ url('upload/images', $category->image) }}" alt="el_img2">
                                        @endif
                                    </div>
                                    <div class="category_info">
                                        <h6 class="product_title text-center"><a href="{{ route('category.sub', $category->slug)}}">{{ $category->name }}</a></h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                        @else
                        <div class="col-md-6">No Category Found</div>
                        @endif
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->

</div>
<!-- END MAIN CONTENT -->

@endsection