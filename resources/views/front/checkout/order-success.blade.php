@extends('front.layouts.app')

@section('title', 'Success')

@section('content')
<!-- START MAIN CONTENT -->
<livewire:frontend.checkout.order-success order_id="{{ $order_id }}" />
<!-- END MAIN CONTENT -->

@endsection
