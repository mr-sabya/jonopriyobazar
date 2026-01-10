@extends('front.layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="main_content py-5">
    <div class="custom-container">
        <div class="row">

            <!-- LEFT SIDEBAR: PROFILE OVERVIEW -->
            <livewire:frontend.user.sidebar />

            <!-- MAIN CONTENT AREA -->
            <livewire:frontend.user.profile />
        </div>
    </div>
</div>
@endsection