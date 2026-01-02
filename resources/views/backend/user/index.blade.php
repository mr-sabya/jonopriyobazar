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
                    <h2><strong>User</strong> List </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="role_table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">Name</th>
                                    <th width="20%">Email</th>
                                    <th width="40%">Roles</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach ($user->roles as $role)
                                        <span class="badge badge-info mr-1">
                                            {{ $role->name }}
                                        </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.admins.edit', $user->id)}}" class="btn {{ Auth::user()->can('admin.admins.edit') ? 'btn-table' : 'btn-disabled disabled'}} waves-effect waves-float waves-green btn-sm"><i class="zmdi zmdi-edit"></i></a>
                                        <button type="button" id="{!! $user->id !!}" class="delete btn {{ Auth::user()->can('admin.admins.destroy') ? 'btn-table' : 'btn-disabled disabled'}} waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Permissions</th>
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
