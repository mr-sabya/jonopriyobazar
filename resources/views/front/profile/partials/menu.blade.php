<div class="profile-card profile-menu">

    <div>
        <div class="pt-2">
            <h6>Mangae My Account</h6>
        </div>
        <div class="profile">
            <ul>
                <li><a href="{{ route('user.profile')}}" class="{{ Route::is('user.profile') ? 'active' : '' }}">My Profile</a></li>
                <li><a href="{{ route('user.address.index')}}" class="{{ Route::is('user.address.index') ? 'active' : '' }}">Address</a></li>
            </ul>
        </div>
    </div>
    <div>
        <div class="pt-4">
            <h6>Manage Order</h6>
        </div>
        <div class="profile">
            <ul>
                <li><a href="{{ route('profile.order.index')}}" class="{{ Route::is('profile.order.index') ? 'active' : '' }}">My Orders</a></li>
                <li><a href="{{ route('profile.customorder.index')}}" class="{{ Route::is('profile.customorder.index') ? 'active' : '' }}">Custom Orders</a></li>
                <li><a href="{{ route('profile.medicine.index')}}" class="{{ Route::is('profile.medicine.index') ? 'active' : '' }}">Medicine Orders</a></li>
                <li><a href="{{ route('profile.electricity.index')}}" class="{{ Route::is('profile.electricity.index') ? 'active' : '' }}">Electricity Bills</a></li>
                
            </ul>
        </div>
    </div>
    <div>
        <div class="pt-4">
            <h6>My Cancelation</h6>
        </div>
        <div class="profile">
            <ul>
                <li><a href="{{ route('profile.product.cancel')}}" class="{{ Route::is('profile.product.cancel') ? 'active' : '' }}">Product Orders</a></li>
                <li><a href="{{ route('profile.custom.cancel')}}" class="{{ Route::is('profile.custom.cancel') ? 'active' : '' }}">Custom Orders</a></li>
                <li><a href="{{ route('profile.medicine.cancel')}}" class="{{ Route::is('profile.medicine.cancel') ? 'active' : '' }}">Medicine Orders</a></li>
                <li><a href="{{ route('profile.electricity.cancel')}}" class="{{ Route::is('profile.electricity.cancel') ? 'active' : '' }}">Electricity Bills</a></li>
            </ul>
        </div>
    </div>
    <div>
        <div class="pt-4">
            <ul style="list-style: none;">
                <li>
                    <h6>
                        <a href="{{ route('profile.refer.index')}}" class="{{ Route::is('profile.refer.index') ? 'active' : '' }}">My Refers</a>
                    </h6>
                </li>
            </ul>
        </div>
    </div>
    <div>
        <div class="pt-4">
            <ul style="list-style: none;">
                <li>
                    <h6>
                        <a href="{{ route('wishlist.index')}}">My Wishlist</a>
                    </h6>
                </li>
            </ul>
        </div>
    </div>

</div>