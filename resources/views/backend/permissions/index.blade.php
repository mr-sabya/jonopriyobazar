@extends('backend.layouts.app')

@section('title', 'Permissions')

@section('button')
<!-- <a href="{{ route('admin.roles.create')}}" class="btn btn-success float-right" type="button" id="add_new"><i class="zmdi zmdi-plus"> Role</i></a> -->
@endsection

@section('content')
<livewire:backend.permissions.index />
@endsection
