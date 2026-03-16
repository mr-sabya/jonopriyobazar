@extends('front.layouts.app')

@section('title', 'Checkout')

@section('content')
<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="container">


            <div class="row justify-content-center">
                <livewire:frontend.address.create />
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->

</div>
<!-- END MAIN CONTENT -->

@endsection