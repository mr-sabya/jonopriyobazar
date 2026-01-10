@extends('front.layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="main_content bg-light py-5">
    <div class="custom-container">
        <div class="row">

            <!-- LEFT SIDEBAR (Reuse the same structure as Profile) -->
            <livewire:frontend.user.sidebar />

            <!-- RIGHT CONTENT: DASHBOARD STATS -->
            <livewire:frontend.user.dashboard />
        </div>
    </div>
</div>
@endsection