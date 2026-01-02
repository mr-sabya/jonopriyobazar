@extends('layouts.back')

@section('title')
Electricity Bill#{{ $order->invoice }}
@endsection

@section('button')

@endsection

@section('content')

<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">
        

        <div class="col-md-12">
            <div class="card">
                <div class="body">
                    <div class="order-info">
                        <h3>Electricity Bill: #{{ $order->invoice }}</h3>
                        <h3><strong>{{ $order->customer['name']}}</strong></h3>
                        <p>Date: {{ date('d-m-Y', strtotime($order->created_at)) }}</p>
                    </div>
                    
                    <div class="row">
                         <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover product-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Company</th>
                                            <th>Prepaid/Postpaid</th>
                                            <th>Phone Number</th>
                                            <th>Meter/Customer Number</th>
                                            <th class="text-right">Amount</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                       
                                        <tr>
                                            <td>1</td>
                                            <td>{{ $order->company['name']}}</td>
                                            <td>{{ $order->company['type']}}</td>
                                            <td>{{ $order->phone }}</td>
                                            <td>{{ $order->meter_no }}</td>
                                            <td class="text-right">{{ $order->grand_total }} ৳</td>
                                        </tr>
                                       
                                    </tbody>
                                   
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       

        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Order</strong> Status </h2>
                </div>
                

                <div class="body">

                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="text-center">
                                @foreach($statuses as $status)

                                @if($status->slug == 'canceled')
                                <hr>
                                <p>To Cancel Order</p>
                                @endif
                                <button class="history btn {{ $order->isActiveHistory($status->id) ? 'btn-success' : 'btn-primary' }} p-3 w-100" data-id="{{ $status->id }}">{{ $status->name }}</button><br>
                                @if(!$loop->last)
                                <i class="zmdi zmdi-long-arrow-down"></i>
                                <br>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Order</strong> History </h2>
                </div>
                <div class="body">
                    <div class="order-info">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover w-100" id="history_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date-Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

</div>




<div class="modal fade" id="history_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <div id="history_modal_loader" class="loader-popup" style="display: none;">
                <img src="{{ url('backend/images/loader.gif')}}">
            </div>
            <div class="modal-header">
                <h4 class="title" id="history_modal_title">Add Hsitory</h4>
            </div>
            <form id="history_form" method="post">
                @csrf
                <div class="modal-body">

                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <div class="form-group">
                        <label for="date_time">Date Time</label>
                        <input type="datetime-local" class="form-control" id="date_time" name="date_time">
                        <span style="color: red" id="date_time_error"></span>
                    </div>

                    <div class="form-group">
                        <label for="date_time">Status</label>
                        <select class="form-control" name="status_id" id="status_id">

                        </select>
                        <span style="color: red" id="status_id_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" id="action" />
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <button type="submit" name="action_button" id="action_button" class="btn btn-primary waves-effect">Save</button>

                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection


@section('scripts')


@include('backend.partials.datatable.js')

<script>

    $('#history_table').DataTable({
        processing: true,
        serverSide: true,
        paging: false,
        searching: false,
        ajax: {
            url: "/control/order/history/{{ $order->id }}",
        },
        columns: [
        {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
        },
        {
            data: 'date_time',
            name: 'date_time'
        },
        {
            data: 'status',
            name: 'status'
        }
        ]
    });


    $(document).on('click', '.history', function () {
        var data_id = $(this).attr('data-id');
        var order_id = '{{ $order->id }}';
        var this_btn = $(this);

        $.ajax({
            url: "{{ route('admin.orderhistory.store') }}",
            method: "POST",
            data: {
                'order_id': order_id,
                'status_id': data_id,
            },
            dataType: "json",
            
            success: function (data) {
                console.log(data);
                if (data.success) {
                    swal({
                        title: "Good job!",
                        text: data.success,
                        icon: "success",
                        button: "Ok!",
                    }).then((success) => {

                        this_btn.removeClass('btn-primary');
                        this_btn.addClass('btn-success');
                        $('#history_modal').modal('hide');
                        $('#history_table').DataTable().ajax.reload();
                    });
                }

            }
        })
    });

    $('#total').keyup(function(event) {
        var total = $(this).val();
        var charge = $('#deliver_charge').val();

        var grand_total = parseInt(total) + parseInt(charge);
        $('#grand_total').val(parseInt(grand_total));
    });

    $(document).on('submit','#update_form',function(e){
        event.preventDefault();
        $.ajax({
            url: $(this).prop('action'),
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function (data) {

                if (data.success) {
                    swal({
                        title: "Good job!",
                        text: data.success,
                        icon: "success",
                        button: "Ok!",
                    })
                }

                if (data.error) {
                    swal({
                        title: "Error!",
                        text: data.error,
                        icon: "warning",
                        button: "Ok!",
                    })
                }
            }
        })
    });

    $(document).on('submit','#payment_form',function(e){
        event.preventDefault();
        $.ajax({
            url: $(this).prop('action'),
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function (data) {

                if (data.success) {
                    swal({
                        title: "Good job!",
                        text: data.success,
                        icon: "success",
                        button: "Ok!",
                    })
                }
            }
        })
    });


</script>


@endsection