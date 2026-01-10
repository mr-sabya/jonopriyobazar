<div class="col-lg-4 col-xl-3 mb-4">
    <div class="card profile-nav-card br-15 mb-4">
        <div class="card-body text-center pt-5">
            <div class="profile-img-wrapper mb-4 position-relative d-inline-block">
                <label for="profile_image_input" class="mb-0" style="cursor: pointer; position: relative; display: block;">

                    @if ($image)
                    <!-- 1. Show the temporary preview while uploading/saving -->
                    <img src="{{ $image->temporaryUrl() }}"
                        class="rounded-circle border shadow-sm"
                        style="width: 120px; height: 120px; object-fit: cover; opacity: 0.6;">
                    @elseif(!empty($current_image))
                    <!-- 2. Show the newly saved image from the public property -->
                    <img src="{{ asset('upload/profile_pic/'.$current_image) }}?t={{ time() }}"
                        class="rounded-circle border shadow-sm"
                        style="width: 120px; height: 120px; object-fit: cover;">
                    @else
                    <!-- 3. Fallback to Avatar if current_image is empty -->
                    <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}"
                        class="rounded-circle border shadow-sm"
                        style="width: 120px; height: 120px;">
                    @endif

                    <!-- Camera Icon Overlay -->
                    <div class="edit-avatar-btn" style="position: absolute; bottom: 5px; right: 5px; background: #28a745; color: #fff; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid #fff;">
                        <i class="fas fa-camera" wire:loading.remove wire:target="image"></i>
                        <i class="fas fa-spinner fa-spin" wire:loading wire:target="image"></i>
                    </div>

                    <!-- Hidden Input -->
                    <input type="file" wire:model="image" id="profile_image_input" class="d-none" accept="image/*">
                </label>
            </div>

            <h5 class="font-weight-bold mb-1">{{ Auth::user()->name }}</h5>
            <p class="text-muted small mb-3">{{ Auth::user()->phone }}</p>

            <div class="mb-4">
                @if(Auth::user()->is_varified == 1)
                <span class="badge badge-pill bg-success-light px-3 py-2"><i class="fas fa-check-circle mr-1"></i> Verified Account</span>
                @else
                <span class="badge badge-pill badge-warning px-3 py-2 text-white">Unverified</span>
                @endif
            </div>

            <div class="copy-code-box mb-2">
                <span class="small font-weight-bold text-muted">Refer: <span id="code" class="text-dark">{{ Auth::user()->affiliate_code }}</span></span>
                <button class="btn btn-link p-0 text-success" onclick="copyCode()" title="Copy Code"><i class="fas fa-copy"></i></button>
            </div>
        </div>

        <div class="card-body p-0 border-top mt-2">
            <div class="p-3">
                <h6 class="text-uppercase small font-weight-bold text-muted mb-0">Manage My Account</h6>
            </div>
            <ul class="nav-list px-2 pb-2">
                <li><a href="{{ route('user.dashboard')}}" class="{{ Route::is('user.dashboard') ? 'active' : '' }}" wire:navigate><i class="fas fa-user-circle"></i> My Dashboard</a></li>
                <li><a href="{{ route('user.profile')}}" class="{{ Route::is('user.profile') ? 'active' : '' }}" wire:navigate><i class="fas fa-user-circle"></i> My Profile</a></li>
                <li><a href="{{ route('user.address.index')}}" class="{{ Route::is('user.address.index') ? 'active' : '' }}" wire:navigate><i class="fas fa-map-marker-alt"></i> Address Book</a></li>
            </ul>

            <div class="p-3 border-top bg-light-gray">
                <h6 class="text-uppercase small font-weight-bold text-muted mb-0">My Orders</h6>
            </div>
            <ul class="nav-list px-2 pb-2">
                <li><a href="{{ route('user.order.index')}}" class="{{ Route::is('user.order.index') ? 'active' : '' }}" wire:navigate><i class="fas fa-shopping-bag"></i> Product Orders</a></li>
                <li><a href="{{ route('user.customorder.index')}}" class="{{ Route::is('user.customorder.index') ? 'active' : '' }}" wire:navigate><i class="fas fa-shopping-cart"></i> Custom Orders</a></li>
                <li><a href="{{ route('user.medicine.index')}}" class="{{ Route::is('user.medicine.index') ? 'active' : '' }}" wire:navigate><i class="fas fa-prescription"></i> Medicine Orders</a></li>
                <li><a href="{{ route('user.electricity.index')}}" class="{{ Route::is('user.electricity.index') ? 'active' : '' }}" wire:navigate><i class="fas fa-bolt"></i> Electricity Bills</a></li>
            </ul>

            <!-- THE CANCELLATION SECTION YOU REQUESTED -->
            <div class="p-3 border-top bg-light-gray">
                <h6 class="text-uppercase small font-weight-bold text-muted mb-0">Order Management</h6>
            </div>
            <ul class="nav-list px-2 pb-2">
                <!-- Main Cancellations Link -->
                <li>
                    <a href="{{ route('user.product.cancel') }}" class="{{ Request::is('user/cancel*') ? 'active' : '' }}">
                        <i class="fas fa-times-circle text-danger"></i>
                        <span class="text-danger font-weight-bold">My Cancellations</span>
                    </a>
                </li>
            </ul>

        </div>
    </div>
</div>