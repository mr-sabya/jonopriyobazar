<div class="col-lg-8 col-xl-9">

    <!-- 1. ADDRESS SUMMARY CARD -->
    <div class="card border-0 shadow-sm br-15 mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="section-title mb-0">Address Book</h5>
                <a href="{{ route('user.address.index')}}" class="btn btn-outline-success btn-sm br-10" wire:navigate>Manage All</a>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="p-3 rounded bg-light border h-100 position-relative">
                        <span class="badge badge-success position-absolute" style="top:10px; right:10px;">Shipping</span>
                        <h6 class="font-weight-bold small text-muted text-uppercase mb-2">Default Shipping</h6>
                        @if($shipping_address)
                        <p class="font-weight-bold mb-1 text-dark">{{ $shipping_address->name }}</p>
                        <p class="small text-muted mb-2"><i class="fas fa-phone-alt mr-1"></i> {{ $shipping_address->phone }}</p>
                        <p class="small text-dark mb-0 line-height-sm">
                            {{ $shipping_address->street }}, {{ $shipping_address->city['name'] }} - {{ $shipping_address->post_code }}
                        </p>
                        @else
                        <p class="small text-muted italic">No shipping address set.</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded bg-light border h-100 position-relative">
                        <span class="badge badge-primary position-absolute" style="top:10px; right:10px;">Billing</span>
                        <h6 class="font-weight-bold small text-muted text-uppercase mb-2">Default Billing</h6>
                        @if($billing_address)
                        <p class="font-weight-bold mb-1 text-dark">{{ $billing_address->name }}</p>
                        <p class="small text-muted mb-2"><i class="fas fa-phone-alt mr-1"></i> {{ $billing_address->phone }}</p>
                        <p class="small text-dark mb-0 line-height-sm">
                            {{ $billing_address->street }}, {{ $billing_address->city['name'] }} - {{ $billing_address->post_code }}
                        </p>
                        @else
                        <p class="small text-muted italic">No billing address set.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- 2. UPDATE PROFILE FORM -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm br-15 h-100">
                <div class="card-body p-4">
                    <h5 class="section-title">Personal Information</h5>
                    <form id="info_form" action="{{ route('user.info.update')}}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-muted">Phone Number</label>
                            <input type="text" class="form-control br-10 bg-light" value="{{ Auth::user()->phone }}" disabled>
                            <small class="text-muted font-italic" style="font-size:10px;">(Mobile number cannot be changed)</small>
                        </div>
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-muted">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control br-10" value="{{ Auth::user()->name }}">
                            <small class="text-danger" id="name_error"></small>
                        </div>
                        <div class="form-group mb-4">
                            <label class="small font-weight-bold text-muted">Username</label>
                            <input type="text" name="username" id="username" class="form-control br-10" value="{{ Auth::user()->username }}">
                            <small class="text-danger" id="username_error"></small>
                        </div>
                        <button type="submit" class="btn btn-success btn-block br-10 shadow-sm font-weight-bold">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- 3. UPDATE PASSWORD FORM -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm br-15 h-100">
                <div class="card-body p-4">
                    <h5 class="section-title">Security & Password</h5>
                    <form id="password_form" action="{{ route('user.password.update')}}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-muted">Current Password</label>
                            <input type="password" name="c_password" id="c_password" class="form-control br-10" placeholder="••••••••">
                            <small class="text-danger" id="c_password_error"></small>
                        </div>
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-muted">New Password</label>
                            <input type="password" name="password" id="password" class="form-control br-10" placeholder="••••••••">
                            <small class="text-danger" id="password_error"></small>
                        </div>
                        <div class="form-group mb-4">
                            <label class="small font-weight-bold text-muted">Confirm New Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control br-10" placeholder="••••••••">
                            <small class="text-danger" id="confirm_password_error"></small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block br-10 shadow-sm font-weight-bold">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>