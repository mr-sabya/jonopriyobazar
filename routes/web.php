<?php

use Illuminate\Support\Facades\Route;

// Home & General Shop
Route::get('/', [App\Http\Controllers\Front\HomeController::class, 'index'])->name('home');
Route::get('category', [App\Http\Controllers\Front\CategoryController::class, 'index'])->name('category.index');
Route::get('category/{slug}', [App\Http\Controllers\Front\CategoryController::class, 'sub'])->name('category.sub');

Route::get('shop', [App\Http\Controllers\Front\ProductController::class, 'index'])->name('product.index');

// Static Pages
Route::get('about', [App\Http\Controllers\Front\PageController::class, 'about'])->name('about');
Route::get('faq', [App\Http\Controllers\Front\PageController::class, 'faq'])->name('faq');
Route::get('refer-policy', [App\Http\Controllers\Front\PageController::class, 'refer'])->name('refer');
Route::get('terms-of-use', [App\Http\Controllers\Front\PageController::class, 'terms'])->name('terms');
Route::get('privacy-policy', [App\Http\Controllers\Front\PageController::class, 'privacy'])->name('privacy');

// Authentication
Route::get('login', [App\Http\Controllers\Front\Auth\LoginController::class, 'showForm'])->name('login');
Route::get('register', [App\Http\Controllers\Front\Auth\RegisterController::class, 'showForm'])->name('register');
Route::get('verify', [App\Http\Controllers\Front\Auth\LoginController::class, 'verifyForm'])->name('otp.verify');

// Forgot Password / Reset
Route::get('forgot-password', [App\Http\Controllers\Front\Auth\ResetController::class, 'forgot'])->name('forgot.password');
Route::get('reset-password/{phone}', [App\Http\Controllers\Front\Auth\ResetController::class, 'resetPasswordForm'])->name('reset.password');


Route::middleware('auth')->group(function () {


    // Cart & Checkout
    Route::get('cart', [App\Http\Controllers\Front\CartController::class, 'index'])->name('cart.index');

    Route::post('cupon/apply', [App\Http\Controllers\Front\CuponController::class, 'apply'])->name('cupon.apply');
    Route::get('cupon/remove/{id}', [App\Http\Controllers\Front\CuponController::class, 'remove'])->name('cupon.remove');

    Route::get('add-address', [App\Http\Controllers\Front\Auth\AddressController::class, 'showForm'])->name('address.showform');
    Route::post('address/default/store', [App\Http\Controllers\Front\Auth\AddressController::class, 'addAddress'])->name('address.default.store');

    Route::get('checkout', [App\Http\Controllers\Front\CheckoutController::class, 'index'])->name('checkout.index');

    // order success
    Route::get('order-success/{order_id}', [App\Http\Controllers\Front\CheckoutController::class, 'orderSuccess'])->name('order.success');

    // Other Orders
    // Custom Order
    Route::get('custom-order', [App\Http\Controllers\Front\Auth\CustomOrderController::class, 'index'])->name('custom.order');

    // Electricity Bill
    Route::get('electricity-bill', [App\Http\Controllers\Front\Auth\ElectricitybillController::class, 'index'])->name('electricity.index');

    // Medicine Order
    Route::get('medicine-order', [App\Http\Controllers\Front\Auth\MedicineController::class, 'index'])->name('medicine.index');

    Route::get('order-complete', [App\Http\Controllers\Front\Auth\OrderController::class, 'complete'])->name('order.complete');

    // Wishlist
    Route::get('wishlist', [App\Http\Controllers\Front\WishlistController::class, 'index'])->name('wishlist.index');
    Route::get('add-wishlist/{id}', [App\Http\Controllers\Front\WishlistController::class, 'store'])->name('wishlist.store');
    Route::get('wishlist/add-cart/{id}', [App\Http\Controllers\Front\WishlistController::class, 'addCart'])->name('wishlist.addcart');
    Route::delete('wishlist/remove/{id}', [App\Http\Controllers\Front\WishlistController::class, 'remove'])->name('wishlist.remove');

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {

        // user menu redirect to profile
        Route::get('/', [App\Http\Controllers\Front\Auth\ProfileController::class, 'dashboard'])->name('dashboard');

        // Profile Management
        Route::get('profile', [App\Http\Controllers\Front\Auth\ProfileController::class, 'index'])->name('profile');

        // Address Management
        Route::get('address', [App\Http\Controllers\Front\Auth\AddressController::class, 'index'])->name('address.index');

        // Wallet Routes (user.wallet.index, user.wallet.show)
        Route::prefix('wallet')->as('wallet.')->group(function () {
            Route::get('/', [App\Http\Controllers\Front\WalletController::class, 'index'])->name('index');
            Route::get('/details', [App\Http\Controllers\Front\WalletController::class, 'show'])->name('show');
        });

        // Refer Routes (user.refer.index, user.refer.balance)
        Route::prefix('refer')->as('refer.')->group(function () {
            Route::get('/', [App\Http\Controllers\Front\ReferController::class, 'index'])->name('index');
            Route::get('/history', [App\Http\Controllers\Front\ReferController::class, 'balance'])->name('balance');
        });


        // Point Routes (user.point.index, user.point.apply)
        Route::prefix('point')->as('point.')->group(function () {
            Route::get('/', [App\Http\Controllers\Front\Auth\PointController::class, 'index'])->name('index');
            Route::get('/prize/apply/{id}', [App\Http\Controllers\Front\Auth\PointController::class, 'apply'])->name('prize.apply');
        });

        Route::get('notifications', [App\Http\Controllers\Front\NotificationController::class, 'index'])->name('notification.index');


        // User Orders in Profile
        Route::get('orders', [App\Http\Controllers\Front\Auth\OrderController::class, 'index'])->name('order.index');
        Route::get('order/{invoice}', [App\Http\Controllers\Front\Auth\OrderController::class, 'show'])->name('order.show');
        Route::get('custom-order', [App\Http\Controllers\Front\Auth\CustomOrderController::class, 'index'])->name('customorder.index');
        Route::get('medicine-order', [App\Http\Controllers\Front\Auth\MedicineController::class, 'index'])->name('medicine.index');
        Route::get('electricity-bill', [App\Http\Controllers\Front\Auth\ElectricitybillController::class, 'index'])->name('electricity.index');

        // Cancel Orders

        Route::get('cancel-orders', [App\Http\Controllers\Front\Auth\CancelController::class, 'index'])->name('order.cancel.index');
        Route::get('order/cancel/{invoice}', [App\Http\Controllers\Front\Auth\CancelController::class, 'cancelOrder'])->name('order.cencel.create');
        Route::get('order-cancel/success', [App\Http\Controllers\Front\Auth\CancelController::class, 'cancelSuccess'])->name('order.cencel.success');
    });
});
