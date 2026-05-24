@extends('backend.layouts.app')

@section('title', 'Refer History')

@section('content')

<livewire:backend.customer.referbalance.manage id="{{ $user->id }}" />
@endsection
