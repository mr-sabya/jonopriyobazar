@extends('backend.layouts.app')

@section('title', 'Roles')

@section('button')
<!-- <a href="{{ route('admin.roles.create')}}" class="btn btn-success float-right" type="button" id="add_new"><i class="zmdi zmdi-plus"> Role</i></a> -->
@endsection

@section('content')
<livewire:backend.roles.index />


@endsection

@section('scripts')

@include('backend.partials.datatable.js')

<script>
    $('#role_table').DataTable();
</script>

@endsection
