@extends('layouts.front')

@section('css')
<link rel="stylesheet" href="{{ asset('frontend/dropify/css/dropify.min.css') }}">
@endsection

@section('title', 'Credit Wallet')

@section('content')
<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="container">
            <div class="mb-3">
                <a href="{{ route('user.wallet')}}"><i class="fas fa-arrow-left"></i> Go Back</a>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-5">
                        <div class="card-body text-center">
                            <h3>Credit Wallet</h3>
                            <h6>Balance: {{ Auth::user()->wallet_balance }}৳</h6>
                            @if($active_package)
                            <p style="color: #000; font-size: 12px; margin: 0;">Exprire On : {{ date('d-m-Y h:i A', strtotime($active_package->valid_to))}}</p>
                            @else
                            <p style="color: #000; font-size: 12px; margin: 0;">Wallet is not Active</p>
                            @endif
                        </div>
                    </div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home">Purchase History</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#payment">Payment History</a>
                        </li>

                    </ul>
                    <div class="tab-content">
                        <div id="home" class="container tab-pane active"><br>
                            <h3>Credit Wallet Purchase History</h3>
                            <div class="table-responsive">
                                <table class="table" id="purchase_table">
                                    <thead>
                                        <tr>
                                            <th>Date#</th>
                                            <th>Order</th>
                                            <th class="text-right">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($purchases as $purchase)
                                        <tr>
                                            <td>{{ date('d-m-Y', strtotime($purchase->date))}}</td>
                                            <td><a href="">#{{ $purchase->order['invoice']}}</a></td>
                                            <td class="text-right">{{ $purchase->amount }}৳</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="payment" class="container tab-pane fade"><br>
                            <h3>Credit Wallet Payments</h3>
                            <div class="table-responsive">
                                <table class="table" id="pay_table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th class="text-right">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pays as $pay)
                                        @if($pay->amount > 0)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ date('d-m-Y', strtotime($pay->date))}}</td>
                                            <td class="text-right">{{ $pay->amount }}৳</td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->

</div>
<!-- END MAIN CONTENT -->

@endsection

@section('script')
<script src="{{ asset('frontend/dropify/js/dropify.min.js') }}"></script>

@include('backend.partials.datatable.js')
<script>

    $('#purchase_table').DataTable();
    $('#pay_table').DataTable();

</script>

</script>

@endsection