<div class="staggered-animation-wrap" style="margin-top: 20px;">
    <div class="custom-container">
        <div class="row">
            <div class="col-lg-9 offset-lg-3">
                <div class="banner_section shop_el_slider">
                    <div id="carouselExampleControls" class="carousel slide carousel-fade light_arrow" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($banners as $banner)
                            <div class="carousel-item {{ $loop->index ==1 ? 'active' : ''}} background_bg" data-img-src="{{ url('upload/images', $banner->image) }}">
                                <div class="banner_slide_content banner_content_inner">
                                    <div class="col-lg-7 col-10">
                                        <div class="banner_content3 overflow-hidden">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <ol class="carousel-indicators indicators_style3">
                            @foreach($banners as $banner)
                            <li data-target="#carouselExampleControls" data-slide-to="0" class="{{ $loop->index ==1 ? 'active' : ''}}"></li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>