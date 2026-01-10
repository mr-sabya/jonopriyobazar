<div class="col-lg-4 col-xl-3 mb-4">
    <div class="card profile-nav-card br-15 mb-4">
        <div class="card-body text-center pt-5">
            <div class="profile-img-wrapper mb-3">
                @if(Auth::user()->image == '')
                <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" alt="Avatar">
                @else
                <img src="{{ url('upload/profile_pic', Auth::user()->image) }}" alt="Avatar">
                @endif
                <div class="edit-avatar-btn" id="edit_image"><i class="fas fa-camera"></i></div>
            </div>

            <!-- Image Upload Form (Hidden initially) -->
            <div id="image_upload_section" style="display:none;" class="mt-3">
                <form id="image_form" action="{{ route('user.image.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="image" id="image" class="form-control form-control-sm mb-2">
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success btn-sm mr-2">Update</button>
                        <button type="button" id="close_edit" class="btn btn-light btn-sm">Cancel</button>
                    </div>
                </form>
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
                <li><a href="{{ route('profile.order.index')}}" class="{{ Route::is('profile.order.index') ? 'active' : '' }}" wire:navigate><i class="fas fa-shopping-bag"></i> Product Orders</a></li>
                <li><a href="{{ route('profile.customorder.index')}}" class="{{ Route::is('profile.customorder.index') ? 'active' : '' }}" wire:navigate><i class="fas fa-shopping-cart"></i> Custom Orders</a></li>
                <li><a href="{{ route('profile.medicine.index')}}" class="{{ Route::is('profile.medicine.index') ? 'active' : '' }}" wire:navigate><i class="fas fa-prescription"></i> Medicine Orders</a></li>
                <li><a href="{{ route('profile.electricity.index')}}" class="{{ Route::is('profile.electricity.index') ? 'active' : '' }}" wire:navigate><i class="fas fa-bolt"></i> Electricity Bills</a></li>
            </ul>

            <!-- THE CANCELLATION SECTION YOU REQUESTED -->
            <div class="p-3 border-top bg-light-gray">
                <h6 class="text-uppercase small font-weight-bold text-muted mb-0">Order Management</h6>
            </div>
            <ul class="nav-list px-2 pb-2">
                <!-- Main Cancellations Link -->
                <li>
                    <a href="{{ route('profile.product.cancel') }}" class="{{ Request::is('profile/cancel*') ? 'active' : '' }}">
                        <i class="fas fa-times-circle text-danger"></i>
                        <span class="text-danger font-weight-bold">My Cancellations</span>
                    </a>
                </li>
            </ul>

        </div>
    </div>
</div>