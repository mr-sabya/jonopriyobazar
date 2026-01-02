@extends('layouts.front')

@section('title', 'Refers')

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
                                    <h2>Refers</h2>
                                    <div class="profile-card mt-3 p-3">
                                        <div class="table-responsive">
                                            <table class="table" id="refer_table">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Phone</th>
                                                        <th class="text-right">Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach($refers as $refer)
                                                    <tr>
                                                        <td>{{ $refer->name }}</td>
                                                        <td><a href="">{{ $refer->phone }}</a></td>
                                                        <td>{{ date('d-m-Y', strtotime($refer->created_at)) }}</td>
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
    $('#refer_table').DataTable();
</script>

@endsection

