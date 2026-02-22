@extends('front.layouts.app')

@section('title', 'Custom Orders')

@section('content')
<div class="main_content py-5">
    <div class="custom-container">
        <div class="row">

            <!-- LEFT SIDEBAR: PROFILE OVERVIEW -->
            <livewire:frontend.user.sidebar />

            <!-- MAIN CONTENT AREA -->
            <livewire:frontend.user.custom-order.index />
        </div>
    </div>
</div>
@endsection

