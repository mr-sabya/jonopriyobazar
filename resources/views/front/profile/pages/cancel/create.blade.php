@extends('front.layouts.app')

@section('title', 'Cancel Orders')

@section('content')

@section('content')
<div class="main_content py-5">
    <div class="custom-container">
        <div class="row">

            <!-- LEFT SIDEBAR: PROFILE OVERVIEW -->
            <livewire:frontend.user.sidebar />

            <!-- MAIN CONTENT AREA -->
            <livewire:frontend.user.cancel-order.manage invoice="{{ $order->invoice }}" />
        </div>
    </div>
</div>
@endsection