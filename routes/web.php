<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\CategoryController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\SearchController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\Auth\LoginController;
use App\Http\Controllers\Front\Auth\RegisterController;
use App\Http\Controllers\Front\Auth\ResetController;
use App\Http\Controllers\Front\Auth\ProfileController;
use App\Http\Controllers\Front\Auth\AddressController;
use App\Http\Controllers\Front\Auth\OrderController as UserOrderController;
use App\Http\Controllers\Front\Auth\CustomOrderController as UserCustomOrderController;
use App\Http\Controllers\Front\Auth\MedicineController as UserMedicineController;
use App\Http\Controllers\Front\Auth\ElectricitybillController as UserElectricitybillController;
use App\Http\Controllers\Front\Auth\CancelController;
use App\Http\Controllers\Front\Auth\ReferController as UserReferController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CuponController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\CustomOrderController;
use App\Http\Controllers\Front\ElectricitybillController;
use App\Http\Controllers\Front\MedicineController;
use App\Http\Controllers\Front\WishlistController;
use App\Http\Controllers\Front\WalletController;
use App\Http\Controllers\Front\ReferController;
use App\Http\Controllers\Front\WithdrawController;
use App\Http\Controllers\Front\Auth\PointController;
use App\Http\Controllers\Front\NotificationController;
use App\Http\Controllers\Front\CommonController;

// Home & General Shop
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('category', [CategoryController::class, 'index'])->name('category.index');
Route::get('category/{slug}', [CategoryController::class, 'sub'])->name('category.sub');

Route::get('shop', [ProductController::class, 'index'])->name('product.index');

// Static Pages
Route::get('about', [PageController::class, 'about'])->name('about');
Route::get('faq', [PageController::class, 'faq'])->name('faq');
Route::get('refer-policy', [PageController::class, 'refer'])->name('refer');
Route::get('terms-of-use', [PageController::class, 'terms'])->name('terms');
Route::get('privacy-policy', [PageController::class, 'privacy'])->name('privacy');

// Authentication
Route::get('login', [LoginController::class, 'showForm'])->name('login');
Route::get('register', [RegisterController::class, 'showForm'])->name('register');
Route::get('verify', [LoginController::class, 'verifyForm'])->name('otp.verify');

// Forgot Password / Reset
Route::get('forgot-password', [ResetController::class, 'forgot'])->name('forgot.password');
Route::post('find-phone', [ResetController::class, 'sendCode'])->name('phone.find');
Route::get('user-verify/{phone}', [ResetController::class, 'verifyForm'])->name('user.verify');
Route::post('user-verify', [ResetController::class, 'verify'])->name('user.verify.submit');
Route::get('reset-password/{phone}', [ResetController::class, 'resetPasswordForm'])->name('reset.password.form');
Route::post('reset-password', [ResetController::class, 'reset'])->name('reset.password.submit');


Route::middleware('auth')->group(function () {
    // Profile Management
    Route::get('profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::post('profile/image', [ProfileController::class, 'updateImage'])->name('user.image.update');
    Route::post('profile/info/update', [ProfileController::class, 'updateInfo'])->name('user.info.update');
    Route::post('profile/password/update', [ProfileController::class, 'updatePassword'])->name('user.password.update');

    // Address Management
    Route::get('customer/address', [AddressController::class, 'index'])->name('user.address.index');
    Route::get('customer/address/create', [AddressController::class, 'create'])->name('user.address.create');
    Route::post('address/store', [AddressController::class, 'store'])->name('user.address.store');
    Route::get('customer/address/{id}/edit', [AddressController::class, 'edit'])->name('user.address.edit');
    Route::post('address/update', [AddressController::class, 'update'])->name('user.address.update');
    Route::get('customer/set-billing-address/{id}', [AddressController::class, 'setBilling'])->name('user.address.setbilling');
    Route::get('customer/set-shipping-address/{id}', [AddressController::class, 'setShipping'])->name('user.address.setshipping');

    // User Orders in Profile
    Route::get('customer/order', [UserOrderController::class, 'index'])->name('profile.order.index');
    Route::get('customer/order/{invoice}', [UserOrderController::class, 'show'])->name('profile.order.show');
    Route::get('customer/custom-order', [UserCustomOrderController::class, 'index'])->name('profile.customorder.index');
    Route::get('customer/custom-order/{invoice}', [UserCustomOrderController::class, 'show'])->name('profile.customorder.show');
    Route::get('customer/medicine-order', [UserMedicineController::class, 'index'])->name('profile.medicine.index');
    Route::get('customer/medicine-order/{invoice}', [UserMedicineController::class, 'show'])->name('profile.medicine.show');
    Route::get('customer/electricity-bill', [UserElectricitybillController::class, 'index'])->name('profile.electricity.index');
    Route::get('customer/electricity-bill/{id}', [UserElectricitybillController::class, 'show'])->name('profile.electricity.show');

    // Cancel Orders
    Route::get('customer/order/cancel/{invoice}', [UserOrderController::class, 'cancelOrder'])->name('profile.order.cencel');
    Route::post('customer/order/cancel/submit', [UserOrderController::class, 'cancelOrderSubmit'])->name('profile.order.cencel.submit');
    Route::get('customer/order-cancel/success', [UserOrderController::class, 'cancelSuccess'])->name('profile.order.cencel.success');

    Route::get('customer/cancel/product-orders', [CancelController::class, 'product'])->name('profile.product.cancel');
    Route::get('customer/cancel/custom-orders', [CancelController::class, 'custom'])->name('profile.custom.cancel');
    Route::get('customer/cancel/medicine-orders', [CancelController::class, 'medicine'])->name('profile.medicine.cancel');
    Route::get('customer/cancel/electricity-bill', [CancelController::class, 'electricity'])->name('profile.electricity.cancel');

    Route::get('customer/refers', [UserReferController::class, 'index'])->name('profile.refer.index');

    // Cart & Checkout
    Route::get('get-cart', [CartController::class, 'index'])->name('cart.store');
    Route::get('add-cart/{id}', [CartController::class, 'store'])->name('cart.store');
    Route::get('add-to-cart', [CartController::class, 'add'])->name('cart.add');
    Route::get('fetch-cart', [CartController::class, 'fetchCart'])->name('cart.fetch');
    Route::delete('cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.delete');
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('cart/increment/{id}', [CartController::class, 'increment'])->name('cart.increment');
    Route::get('cart/decrement/{id}', [CartController::class, 'decrement'])->name('cart.increment');

    Route::post('cupon/apply', [CuponController::class, 'apply'])->name('cupon.apply');
    Route::get('cupon/remove/{id}', [CuponController::class, 'remove'])->name('cupon.remove');

    Route::get('add-address', [AddressController::class, 'showForm'])->name('address.showform');
    Route::post('address/default/store', [AddressController::class, 'addAddress'])->name('address.default.store');

    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('order', [OrderController::class, 'order'])->name('user.order');

    // Other Orders
    // Custom Order
    Route::get('custom-order', [CustomOrderController::class, 'index'])->name('custom.order');

    // Electricity Bill
    Route::get('electricity-bill', [ElectricitybillController::class, 'index'])->name('electricity.index');

    // Medicine Order
    Route::get('medicine-order', [MedicineController::class, 'index'])->name('medicine.index');

    Route::get('order-complete', [OrderController::class, 'complete'])->name('order.complete');

    // Wishlist
    Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::get('add-wishlist/{id}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::get('wishlist/add-cart/{id}', [WishlistController::class, 'addCart'])->name('wishlist.addcart');
    Route::delete('wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');

    // Wallet & Points
    Route::get('wallet', [WalletController::class, 'index'])->name('user.wallet');
    Route::get('wallet/details', [WalletController::class, 'show'])->name('user.wallet.show');

    Route::get('refers', [ReferController::class, 'index'])->name('user.refer.index');
    Route::get('refer/history', [ReferController::class, 'balance'])->name('user.refer.balance');

    Route::get('withdraw-list', [WithdrawController::class, 'index'])->name('user.withdraw.index');
    Route::post('withdraw/request', [WithdrawController::class, 'store'])->name('user.withdraw.store');

    Route::get('my-point', [PointController::class, 'index'])->name('user.point.index');
    Route::get('prize/apply/{id}', [PointController::class, 'apply'])->name('user.prize.apply');

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('user.notification.index');
    Route::get('fetch/notifications', [NotificationController::class, 'fetch']);
    Route::get('notifications/{id}', [NotificationController::class, 'show'])->name('user.notification.show');
    Route::get('notifications/mark/read', [NotificationController::class, 'markRead'])->name('user.notification.read');
});
