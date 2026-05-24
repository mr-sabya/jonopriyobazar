@extends('backend.layouts.app')

@section('title', 'Customer')

@section('content')
<livewire:backend.customer.show id="{{ $user->id }}" />
@endsection