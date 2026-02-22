@extends('front.layouts.app')

@section('title')
New Password
@endsection


@section('content')
<!-- START MAIN CONTENT -->
<livewire:frontend.auth.reset-password phone="{{ $user->phone }}" />
<!-- END MAIN CONTENT -->

@endsection