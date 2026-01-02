@extends('layouts.back')

@section('title', 'Roles')

@section('button')
<!-- <a href="{{ route('admin.roles.create')}}" class="btn btn-success float-right" type="button" id="add_new"><i class="zmdi zmdi-plus"> Role</i></a> -->
@endsection

@section('content')
<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">

                <div class="header">
                    <h2><strong>Role</strong> List </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="role_table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="15%">Name</th>
                                    <th style="text-align: left;" width="65%">Permissions</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td style="text-align: left;">
                                        @foreach ($role->permissions as $permission)
                                        <span class="badge badge-info mr-1">
                                            {{ $permission->name }}
                                        </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.roles.edit', $role->id)}}" class="btn {{ Auth::user()->can('admin.roles.edit') ? 'btn-table' : 'btn-disabled disabled'}} waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-edit"></i></a>
                                        <button type="button" id="{!! $role->id !!}" class="delete btn {{ Auth::user()->can('admin.roles.destroy') ? 'btn-table' : 'btn-disabled disabled'}} waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th style="text-align: left;">Permissions</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')

@include('backend.partials.datatable.js')

<script>
    $('#role_table').DataTable();
</script>

@endsection
