@extends('layouts.front')

@section('title', 'Faq')

@section('content')

<!-- STAT SECTION ABOUT --> 
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="heading_s1">
                    <h2>Faq</h2>
                </div>

                @foreach($faqs as $faq)
                <div class="faq">
                    <p class="question">প্রশ্নঃ {{ $faq->question }}</p>
                    <p class="answer">উত্তরঃ {{ $faq->answer }}</p>
                </div>
                @endforeach


            </div>
            
        </div>
    </div>
</div>
<!-- END SECTION ABOUT --> 



@endsection

