@extends('layouts.back')

@section('title', 'Sale Report')


@section('content')

<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">

        <div class="col-md-12">
            <div class="card">

                <div class="header">
                    <h2><strong>Sale</strong> Report </h2>
                </div>
                <div class="body">


                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>From</label>
                                <input type="date" name="from" id="from" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>To</label>
                                <input type="date" name="to" id="to" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Order Type</label>
                                <select class="form-control" name="type" id="type">
                                    <option value="all">All Type</option>
                                    <option value="product">Product Order</option>
                                    <option value="custom">Custom Order</option>
                                    <option value="medicine">Medicine Order</option>
                                    <option value="electricity">Electricity Bill</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Payment Type</label>
                                <select class="form-control" name="payment_option" id="payment_option">
                                    <option value="all">All Type</option>
                                    <option value="cash">Cash On Delivery</option>
                                    <option value="wallet">Credit Wallet</option>
                                    <option value="refer">Refer Wallet</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button id="filter" class="btn btn-primary">Generate</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Report</strong> Result </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="customer_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Invoice</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Type</th>
                                    <th>Payment Option</th>
                                    <th>Amount</th>

                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>




    @endsection
    @section('scripts')
    @include('backend.partials.datatable.js')

    <script>

        $('#customer_data').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
            ],
        });

        $(document).ready(function(){


            $('#filter').click(function(){
                $('#customer_data').DataTable().destroy();
                var from = $('#from').val();
                var to = $('#to').val();
                var type = $('#type').val();
                var payment_option = $('#payment_option').val();

                if(from != '' &&  to != '' && type != '' && payment_option != '')
                {
                    $('#customer_data').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                        ],
                        processing: true,
                        serverSide: true,
                        ajax:{
                            url: "{{ route('sale.report.search') }}",
                            data:{
                                from:from, 
                                to:to,
                                type:type,
                                payment_option:payment_option,
                            }
                        },
                        columns: [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data:'invoice',
                            name:'invoice'
                        },
                        {
                            data:'name',
                            name:'name'
                        },
                        {
                            data:'phone',
                            name:'phone'
                        },
                        {
                            data:'type',
                            name:'type'
                        },
                        {
                            data:'payment_method',
                            name:'payment_method'
                        },
                        {
                            data:'grand_total',
                            name:'grand_total'
                        },
                        ]
                    });
                }
                
            });

        });


    </script>


    @endsection