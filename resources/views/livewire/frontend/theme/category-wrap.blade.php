<div class="categories_wrap" x-data="{ showMore: false }">
    <!-- Category Toggle Button -->
    <button
        id="{{ Route::is('home') ? '' : 'menu_button' }}"
        class="categories_btn bg-transparent text-dark border-0"
        data-bs-toggle="collapse"
        data-bs-target="#navCatContent">
        <i class="lnr lnr-menu"></i><span>All Categories</span>
    </button>

    <div id="navCatContent" class="nav_cat navbar collapse {{ Route::is('home') ? 'show' : 'sub-menu' }}">
        <ul>
            @foreach($menucategories as $menucategory)
            {{-- Hide categories after index 12 unless 'showMore' is true --}}
            <li
                @if($loop->index >= 12) x-show="showMore" x-transition @endif
                class="{{ $menucategory->sub->count() > 0 ? 'dropdown dropdown-mega-menu' : '' }}">

                @if($menucategory->sub->count() > 0)
                <!-- Parent with Sub-menu -->
                <a class="dropdown-item nav-link dropdown-toggler" href="#" data-bs-toggle="dropdown">
                    @if($menucategory->icon)
                    <img src="{{ url('upload/images', $menucategory->icon) }}" alt="{{ $menucategory->name }}" style="width: 20px; height: 20px; margin-right: 10px; object-fit: contain;">
                    @endif
                    <span>{{ $menucategory->name }}</span>
                </a>

                <div class="dropdown-menu">
                    <ul class="mega-menu">
                        @foreach($menucategory->sub as $sub)
                        <li class="{{ $sub->sub->count() > 0 ? 'dropdown sub-dropdown' : '' }}">
                            @if($sub->sub->count() > 0)
                            <a class="dropdown-item nav-link dropdown-toggler"
                                href="#">
                                <span>{{ $sub->name }}</span>
                            </a>
                            @else
                            <a class="dropdown-item nav-link nav_item"
                                href="{{ url('/shop?category=' . $sub->slug) }}"
                                wire:navigate>
                                <span>{{ $sub->name }}</span>
                            </a>
                            @endif

                            @if($sub->sub->count() > 0)
                            <div class="sub-dropdown-menu show-sub">
                                <ul>
                                    @foreach($sub->sub as $subcat)
                                    <li>
                                        <a class="dropdown-item nav-link nav_item"
                                            href="{{ url('/shop?category=' . $subcat->slug) }}"
                                            wire:navigate>
                                            {{ $subcat->name }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
                @else
                <!-- Simple Parent Link (No children) -->
                <a class="dropdown-item nav-link nav_item"
                    href="{{ url('/shop?category=' . $menucategory->slug) }}"
                    wire:navigate>
                    @if($menucategory->icon)
                    <img src="{{ url('upload/images', $menucategory->icon) }}" alt="{{ $menucategory->name }}" style="width: 20px; height: 20px; margin-right: 10px; object-fit: contain;">
                    @endif
                    <span>{{ $menucategory->name }}</span>
                </a>
                @endif
            </li>
            @endforeach
        </ul>

        @if($menucategories->count() > 12)
        <div class="more_categories"
            @click="showMore = !showMore"
            style="cursor: pointer; padding: 10px; text-align: center; font-weight: bold; border-top: 1px solid #eee;">
            <span x-text="showMore ? 'Show Less' : 'More Categories'"></span>
        </div>
        @endif
    </div>
</div>