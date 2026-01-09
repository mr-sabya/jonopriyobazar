@extends('front.layouts.app')

@section('title')
Electricity Bill
@endsection

@section('content')
<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START SECTION SHOP -->
    <livewire:frontend.electricity.index />
    <!-- END SECTION SHOP -->

</div>
<!-- END MAIN CONTENT -->

@endsection
