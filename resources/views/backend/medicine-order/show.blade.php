@extends('backend.layouts.app')

@section('title')
Medicine Order#{{ $order->invoice }}
@endsection

@section('button')

@endsection

@section('content')

<livewire:backend.medicine-order.show id="{{ $order->id }}" />

@endsection