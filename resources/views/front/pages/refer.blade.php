@extends('layouts.front')

@section('title', 'Refer Policy')

@section('content')

<!-- STAT SECTION ABOUT --> 
<div class="section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="heading_s1">
                    <h2>Refer Policy</h2>
                </div>
                <div>
                    {!! $setting->refer !!}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION ABOUT --> 




@endsection

