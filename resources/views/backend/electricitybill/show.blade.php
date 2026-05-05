@extends('backend.layouts.app')

@section('title')
Electricity Bill#{{ $order->invoice }}
@endsection


@section('content')

<livewire:backend.electricity-bill.show id="{{ $order->id }}" />
@endsection