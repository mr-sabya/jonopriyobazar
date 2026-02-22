@extends('front.layouts.app')

@section('title')
Forgot Password
@endsection

@section('link')
<li class="breadcrumb-item active">Forgot Password</li>
@endsection

@section('content')
<!-- START MAIN CONTENT -->
<livewire:frontend.auth.forgot-password />
<!-- END MAIN CONTENT -->

@endsection