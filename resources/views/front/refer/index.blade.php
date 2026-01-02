@extends('layouts.front')

@section('css')
<link rel="stylesheet" href="{{ asset('frontend/dropify/css/dropify.min.css') }}">
@endsection

@section('title', 'Refer History')

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
                            <h3>Refers</h3>
                            <h6>Total: {{ Auth::user()->refers->count() }}</h6>
                        </div>
                    </div>
                    
                    
                    <div class="table-responsive">
                        <table class="table" id="balanace_table">
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
    <!-- END SECTION SHOP -->

</div>
<!-- END MAIN CONTENT -->




@endsection

@section('script')
<script src="{{ asset('frontend/dropify/js/dropify.min.js') }}"></script>
@include('backend.partials.datatable.js')
<script>

    $('#balanace_table').DataTable();
    

</script>

@endsection