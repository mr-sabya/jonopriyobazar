@extends('layouts.front')

@section('title', 'About')

@section('content')

<!-- STAT SECTION ABOUT --> 
<div class="section">
    <div class="container">
        <div class="row align-items-center">
            
            <div class="col-lg-12">
                <div class="heading_s1">
                    <h2>আমাদের সম্পর্কে</h2>
                </div>
                {!! $setting->about_1 !!}
            </div>
        </div>
    </div>
</div>
<!-- END SECTION ABOUT --> 

<!-- START SECTION WHY CHOOSE --> 
<div class="section bg_light_blue2 pb_70">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="heading_s1 text-center">
                    <h2>কেন আমাদের বেছে নিবেন?</h2>
                </div>
                <div class="text-center leads">{!! $setting->about_2 !!}</div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-sm-6">
                <div class="icon_box icon_box_style4 box_shadow1">
                    
                    <div class="icon_box_content">
                        <div class="text-center">
                            <img src="{{ url('frontend/images/fast delivert.png')}}" style="width: 50%"/>
                        </div>
                        <h5>খুলনা সিটির মধ্যে মাত্র ১ ঘন্টায় ডেলিভারী।</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="icon_box icon_box_style4 box_shadow1">
                    <div class="icon_box_content">
                        <div class="text-center">
                            <img src="{{ url('frontend/images/like.png')}}" style="width: 50%"/>
                        </div>
                        <h5>মানসম্মত পণ্য গ্রাহককে প্রদান করাই আমাদের লক্ষ্য।</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="icon_box icon_box_style4 box_shadow1">
                    
                    <div class="icon_box_content">
                        <div class="text-center">
                            <img src="{{ url('frontend/images/gift.png')}}" style="width: 50%"/>
                        </div>
                        <h5>আমাদের সকল পণ্যে ডিসকাউন্ট এবং পয়েন্ট রয়েছে।</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION WHY CHOOSE --> 

<!-- START SECTION TEAM -->
<div class="section pb_70">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="heading_s1 text-center">
                    <h2>Our Team Members</h2>
                </div>
                <p class="text-center leads">A short introduction of our team members</p>
            </div>
        </div>
        <div class="row justify-content-center">

            @foreach($teams as $team)
            <div class="col-lg-3 col-sm-6">
                <div class="team_box team_style1">
                    <div class="team_img">
                        @if($team->image == null)
                        <img src="{{ url('frontend/images/default_profile.png') }}" alt="team_img1">
                        @else
                        <img src="{{ url('upload/images', $team->image) }}" alt="team_img1">
                        @endif
                    </div>
                    <div class="team_content">
                        <div class="team_title">
                            <h5>{{ $team->name }}</h5>
                            <span>{{ $team->designation }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
            
        </div>
    </div>
</div>
<!-- END SECTION TEAM -->




@endsection

