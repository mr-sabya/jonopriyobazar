<div class="categories_wrap">
    <button id="{{ Route::is('home') ? '' : 'menu_button' }}" class="categories_btn bg-transparent text-dark border-0" data-toggle="collapse" data-target="#navCatContent">
        <i class="lnr lnr-menu"></i><span>All Categories</span>
    </button>

    <div id="navCatContent" class="nav_cat navbar collapse {{ Route::is('home') ? '' : 'sub-menu' }}">
        <ul>
            {{-- The @php block was removed from here --}}
            @foreach($menucategories as $menucategory)
            @if($menucategory->sub->count() > 0)
            <li class="dropdown dropdown-mega-menu {{ $loop->index >= 12 ? 'more_slide_open' : '' }}">
                <a class="dropdown-item nav-link dropdown-toggler" href="#" data-toggle="dropdown"> <span>{{ $menucategory->name }}</span></a>
                <div class="dropdown-menu">
                    <ul class="mega-menu">
                        @foreach($menucategory->sub as $sub)
                        @if($sub->sub->count() > 0)
                        <li class="dropdown sub-dropdown">
                            <a class="dropdown-item nav-link dropdown-toggler" href="#" data-toggle="dropdown"><span>{{ $sub->name }}</span></a>
                            <div class="sub-dropdown-menu show-sub">
                                <ul>
                                    @foreach($sub->sub as $subcat)
                                    <li><a class="dropdown-item nav-link nav_item" href="{{ route('category.sub', $subcat->slug)}}">{{ $subcat->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @else
                        <li class="dropdown ">
                            <a class="dropdown-item nav-link" href="{{ route('category.sub', $sub->slug)}}"><span>{{ $sub->name }}</span></a>
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </div>
            </li>
            @else
            <li class="{{ $loop->index >= 12 ? 'more_slide_open' : '' }}">
                <a class="dropdown-item nav-link nav_item" href="{{ route('category.sub', $menucategory->slug) }}"><span>{{ $menucategory->name }}</span></a>
            </li>
            @endif
            @endforeach
        </ul>
        <div class="more_categories">More Categories</div>
    </div>
</div>