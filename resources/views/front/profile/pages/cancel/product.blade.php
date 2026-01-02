@extends('layouts.front')

@section('title', 'Product Orders')

@section('content')

<!-- END MAIN CONTENT -->
<div class="main_content">

    <div class="section small_pt pb-0">
        <div class="custom-container">
            <div class="row profile-row">

                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-lg-3">
                            @include('front.profile.partials.profile')
                        </div>
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-lg-3">

                                    @include('front.profile.partials.menu')
                                </div>
                                
                                <div class="col-lg-9 pt-3">
                                    <h2>Product Orders</h2>
                                    <div class="profile-card mt-3 p-3">
                                        <div class="table-responsive">
                                            <table class="table" id="order_table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Date</th>
                                                        <th>Order#Invoice</th>
                                                        <th class="text-center">Amount</th>
                                                        <th>Payment By</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($orders as $order)
                                                    <tr>
                                                        <td>{{ $loop->index+1 }}</td>
                                                        <td>
                                                            {{ date('d-m-Y', strtotime($order->created_at)) }}<br>
                                                            {{ $order->created_at->diffForHumans() }}
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('profile.order.show', $order->invoice)}}">#{{ $order->invoice }}</a>
                                                        </td>
                                                        <td class="text-center">{{ $order->grand_total }}৳</td>
                                                        <td>
                                                            @if($order->payment_option == 'cash')
                                                            Cash On Deliver
                                                            @elseif($order->payment_option == 'wallet')
                                                            Credit Wallet
                                                            @elseif($order->payment_option == 'refer')
                                                            Refer Balance
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($order->status == 0)
                                                            <span class="badge badge-warning">
                                                                Pending
                                                            </span>
                                                            @elseif($order->status == 1)
                                                            <span class="badge badge-primary">
                                                                Received
                                                            </span>
                                                            @elseif($order->status == 2)
                                                            <span class="badge badge-info">
                                                                Processing
                                                            </span>
                                                            @elseif($order->status == 3)
                                                            <span class="badge badge-success">
                                                                Completed
                                                            </span>
                                                            @elseif($order->status == 4)
                                                            <span class="badge badge-dark">
                                                                Canceled
                                                            </span>
                                                            @endif
                                                        </td>
                                                    </tr>
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
            </div>


        </div>
    </div>
</div>
</div>


<!-- END MAIN CONTENT -->

@endsection

@section('script')
<script src="{{ asset('backend/plugins/dropify/js/dropify.min.js') }}"></script>
@include('backend.partials.datatable.js')
<script>
    $('#order_table').DataTable();
</script>

@endsection

