@extends('layouts.front')

@section('title', 'Vouchers')

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
                                    <h2>Vouchers</h2>
                                    <div class="shadow-lg bg-white rounded mt-3 p-3">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Status</th>
                                                    <th>Uses</th>
                                                    <th>Voucher Code</th>
                                                    <th>Valid From</th>
                                                    <th>Valid Until</th>
                                                    <th>Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Name</td>
                                                    <td>Address</td>
                                                    <td>Region</td>
                                                    <td>Phone Number</td>
                                                    <td>Address Type</td>
                                                    <td>Action</td>
                                                </tr>
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


<!-- END MAIN CONTENT -->

@endsection

@section('script')

@endsection

