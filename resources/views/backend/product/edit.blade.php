@extends('backend.layouts.app')

@section('title', 'Edit Product')

@section('content')
<livewire:backend.product.manage productId="{{ $product->id }}" />
@endsection
