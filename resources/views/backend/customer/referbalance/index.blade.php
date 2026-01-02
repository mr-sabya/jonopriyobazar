@extends('layouts.back')

@section('title', 'Refer History')

@section('content')

<div class="container-fluid customer">
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-md-12">
            <a href="{{ route('admin.customer.show', $user->id)}}"><i class="zmdi zmdi-arrow-left"></i> Go Back</a>
            <div class="card">
                <div class="body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <div class="avatar">
                                    @if($user->image == null)
                                    <img src="{{ $user->getUrlfriendlyAvatar($size=400)}}" alt="{{ $user->name }}">
                                    @else
                                    <img src="{{ url('upload/profile_pic', $user->image)}}" alt="{{ $user->name }}">
                                    @endif
                                    @if($user->is_varified == 1)
                                    <span class="verify-status active"><i class="zmdi zmdi-check-circle"></i></span>
                                    @else
                                    <span class="verify-status deactive"><i class="zmdi zmdi-close-circle"></i></span>
                                    @endif
                                </div>
                            </div>
                            <div class="name">
                                <h3>{{ $user->name}}</h3>
                                <p>{{ $user->phone }}</p>
                                <div class="status">
                                    @if($user->status == 1)
                                    <span class="badge badge-success">Active</span>
                                    @elseif($customer->status == 2)
                                    <span class="badge badge-warning">Hold</span>
                                    @else
                                    <span class="badge badge-danger">Deactive</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="body text-center">
                    <div class="row">

                        <div class="col-12">
                            <h4 class="p-0 m-0">Refer Balance <br><strong><span id="total_purchase">{{ $user->ref_balance }}</span></strong> ৳</h4>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>




        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Refer</strong> History </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="refer_table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th>Date</th>
                                    <th>Order</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
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

    var user_id = "{{ $user->id }}";

    $('#refer_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/control/user/refer/history/"+user_id,
        },
        columns: [
        {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
        },
        {
            data: 'order_date',
            name: 'order_date'
        },
        {
            data: 'order',
            name: 'order'
        },
        {
            data: 'amount',
            name: 'amount'
        },

        ]
    });

    


</script>


@endsection