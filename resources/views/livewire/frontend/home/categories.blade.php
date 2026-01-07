<div class="section small_pt pb-0 categories">
    <div class="custom-container">
        <div class="row">
            <div class="col-xl-12">
                <!-- Professional Header -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="heading_s2">
                        <h4 class="m-0 font-weight-bold" style="letter-spacing: -0.5px;">Shop by Category</h4>
                    </div>
                    <a href="{{ route('category.index') }}" class="btn-link text-main-color font-weight-bold">
                        See All <i class="fas fa-arrow-right ml-1" style="font-size: 11px;"></i>
                    </a>
                </div>

                <div class="row">
                    @foreach($categories as $category)
                    <div class="col-lg-2 col-md-3 col-6">
                        <div class="category-card mb-4">
                            <a href="{{ route('category.sub', $category->slug)}}" class="category-anchor">
                                <div class="cat-img-container">
                                    @if($category->icon == null)
                                    <img src="{{ url('frontend/images/demo.png')}}" alt="demo">
                                    @else
                                    <img src="{{ url('upload/images', $category->icon) }}" alt="{{ $category->name }}">
                                    @endif
                                </div>
                                <div class="cat-details">
                                    <span class="cat-name">{{ $category->name }}</span>
                                    <small class="cat-explore">Explore <i class="fas fa-chevron-right"></i></small>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>