@extends('front.layouts.app')

@section('title')
@if($category)
{{ $category->name }}
@else
All Category
@endif
@endsection

@section('content')
<div class="main_content">
    <!-- Passing the category ID or object to Livewire -->
    <livewire:frontend.category.index :currentCategory="$category" />
</div>
@endsection