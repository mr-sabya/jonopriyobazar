@extends('layouts.front')

@section('css')
<link rel="stylesheet" href="{{ asset('frontend/dropify/css/dropify.min.css') }}">
@endsection

@section('title', 'Point History')

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
                            <h3>Total Point</h3>
                            <h6>Balance: {{ Auth::user()->point }}</h6>
                            
                        </div>
                    </div>

                    <div class="mb-5">
                        <h3>Prize List</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    @foreach($prizes as $prize)
                                    <tr>
                                        <td style="vertical-align: middle; text-align: center;"><img src="{{ url('upload/images', $prize->prize)}}" style="width: 100px"></td>
                                        <td style="vertical-align: middle; text-align: center;">{{ $prize->title }}</td>
                                        <td style="vertical-align: middle; text-align: center;">{{ $prize->point }} Points</td>
                                        <td style="vertical-align: middle; text-align: center;">
                                            @if(Auth::user()->point >= $prize->point)
                                            <a href="{{ route('user.prize.apply', $prize->id)}}" class="btn btn-warning">Claim</a>
                                            @else
                                            <button class="btn btn-warning disabled" disabled>Claim</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home">Point History</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#prize">Prize History</a>
                        </li>

                    </ul>
                    <div class="tab-content">
                        <div id="home" class="container tab-pane active"><br>
                            <h3>Point History</h3>
                            <div class="table-responsive">
                                <table class="table" id="purchase_table">
                                    <thead>
                                        <tr>
                                            <th>Date#</th>
                                            <th>Order</th>
                                            <th class="text-right">Point</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($points as $point)
                                        <tr>
                                            <td>{{ date('d-m-Y', strtotime($point->date))}}</td>
                                            <td><a href="">#{{ $point->order['invoice']}}</a></td>
                                            <td class="text-right">{{ $point->point }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="prize" class="container tab-pane fade"><br>
                            <h3>Prize History</h3>
                            <div class="table-responsive">
                                <table class="table" id="pay_table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Prize</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user_prizes as $user_prize)
                                        <tr>
                                            <td>{{ $loop->index+1}}</td>
                                            <td>{{ date('d-m-Y', strtotime($user_prize->created_at))}}</td>
                                            <td>{{ $user_prize->prize['title']}}</td>
                                            <td>
                                                @if($user_prize->status == 0)
                                                <span class="badge badge-info">Pending</span>
                                                @elseif($user_prize->status == 1)
                                                <span class="badge badge-success">Completed</span>
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

@endsection