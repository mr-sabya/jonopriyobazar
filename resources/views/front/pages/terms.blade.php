@extends('layouts.front')

@section('title', 'Terms of Use')

@section('content')

<!-- STAT SECTION ABOUT --> 
<div class="section">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-12">
				<div class="heading_s1">
					<h2>Terms of Use</h2>
				</div>
				<div>
					{!! $setting->terms !!}
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END SECTION ABOUT --> 




@endsection

