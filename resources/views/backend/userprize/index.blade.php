@extends('layouts.back')

@section('title', 'User Prize')

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
                    <h2><strong>User Prize</strong> List </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="role_table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Prize</th>
                                    <th>Point</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($userprizes as $prize)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $prize->user['name'] }}</td>
                                    <td>{{ $prize->user['phone'] }}</td>
                                    <td>
                                        {{ $prize->prize['title']}}
                                    </td>
                                    <td>
                                        {{ $prize->prize['point']}}

                                    </td>
                                    <td>
                                        @if($prize->status == 0)
                                        <span style="color: red">Pending</span>
                                        @else
                                        <span style="color: green">Given</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($prize->status == 0)
                                        <a href="{{ route('admin.userprize.update', $prize->id)}}" class="btn btn-table waves-effect waves-float waves-green btn-sm">Complete</a>
                                        @else
                                        <a href="{{ route('admin.userprize.update', $prize->id)}}" class="btn btn-table btn-disabled disabled waves-effect waves-float waves-green btn-sm">Completed</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Prize</th>
                                    <th>Point</th>
                                    <th>Status</th>
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
