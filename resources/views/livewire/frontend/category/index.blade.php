<div class="section categories category-page">
    <div class="custom-container">
        <div class="row">
            <div class="col-12">
                <div class="row justify-content-center">
                    @if($categories->count() > 0)
                    @foreach($categories as $category)
                    <div class="col-lg-2 col-md-3 col-sm-6 col-12">
                        <div class="category-card mb-4">
                            {{-- LOGIC: If has children go to sub-category page, else go to shop --}}
                            @php
                            $targetUrl = ($category->subcategories_count > 0)
                            ? route('category.sub', $category->slug)
                            : url('/shop?category=' . $category->slug);
                            @endphp

                            <a href="{{ $targetUrl }}" wire:navigate class="category-anchor">
                                <div class="cat-img-container">
                                    @if($category->icon == null)
                                    <img src="{{ url('frontend/images/demo.png') }}" alt="demo">
                                    @else
                                    <img src="{{ url('upload/images', $category->image) }}" alt="{{ $category->name }}">
                                    @endif
                                </div>
                                <div class="cat-details">
                                    <span class="cat-name">{{ $category->name }} </span>
                                    <small class="cat-explore">Explore <i class="fas fa-chevron-right"></i></small>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="col-12 text-center">
                        <p>No Categories Found</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>