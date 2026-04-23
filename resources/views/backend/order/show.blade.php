@extends('backend.layouts.app')

@section('title', 'Order List')

@section('button')

@endsection

@section('content')

<livewire:backend.order.show orderId="{{ $order->id }}" />

@endsection