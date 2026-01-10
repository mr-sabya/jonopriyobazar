@extends('front.layouts.app')

@section('title', 'Address Book')

@section('content')

<!-- END MAIN CONTENT -->
<div class="main_content">

    <div class="section small_pt pb-0">
        <div class="custom-container">
            <div class="row">

                <!-- LEFT SIDEBAR (Reuse the same structure as Profile) -->
                <livewire:frontend.user.sidebar />

                <livewire:frontend.user.address />
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT -->
@endsection