@extends('front.layouts.app')

@section('title')
Custom Order
@endsection

@section('content')
<!-- START MAIN CONTENT -->
<div class="main_content">
    <!-- START SECTION SHOP -->
    <livewire:frontend.custom-order.index />
    <!-- END SECTION SHOP -->
</div>
<!-- END MAIN CONTENT -->
@endsection