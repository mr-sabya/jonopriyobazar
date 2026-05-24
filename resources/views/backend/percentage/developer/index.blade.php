@extends('backend.layouts.app')

@section('title', 'Developer')

@section('button')
<button class="btn btn-success btn-icon float-right" type="button" id="add_new"><i class="zmdi zmdi-plus"></i></button>
@endsection

@section('content')

<livewire:backend.percentage.developer.manage />
@endsection