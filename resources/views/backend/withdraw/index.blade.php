@extends('layouts.back')

@section('title', 'User Withdraw')



@section('content')
<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">

                <div class="header">
                    <h2><strong>User Withdraw</strong> List </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="role_table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($withdraws as $withdraw)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $withdraw->user['name'] }}</td>
                                    <td>{{ $withdraw->user['phone'] }}</td>
                                    <td>
                                        {{ $withdraw->amount }}
                                    </td>
                                    
                                    <td>
                                        @if($withdraw->status == 0)
                                        <span style="color: red">Pending</span>
                                        @else
                                        <span style="color: green">Completed</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($withdraw->status == 0)
                                        <a href="{{ route('admin.withdraw.update', $withdraw->id)}}" class="btn btn-table waves-effect waves-float waves-green btn-sm">Complete</a>
                                        @else
                                        <a href="{{ route('admin.withdraw.update', $withdraw->id)}}" class="btn btn-table btn-disabled disabled waves-effect waves-float waves-green btn-sm">Completed</a>
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
                                    <th>Amount</th>
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
