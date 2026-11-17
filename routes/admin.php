<?php

use Illuminate\Support\Facades\Route;

// Login
Route::get('login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');


Route::middleware(['auth:admin'])->group(function () {

    // Error page
    Route::get('404', [App\Http\Controllers\Admin\ErrorController::class, 'error404'])->name('error.404');

    // Dashboard
    Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('dashboard');

    // Permissions
    Route::get('permissions', [App\Http\Controllers\Admin\PermissionController::class, 'index'])->name('permissions.index')->middleware('permission:admin.permissions.index,admin');

    // Roles
    Route::get('roles', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles.index')->middleware('permission:admin.roles.index,admin');

    // Admins
    Route::prefix('admins')->name('admins.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('index')->middleware('permission:admin.admins.index,admin');
        Route::get('/create', [App\Http\Controllers\Admin\AdminController::class, 'create'])->name('create')->middleware('permission:admin.admins.create,admin');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\AdminController::class, 'edit'])->name('edit')->middleware('permission:admin.admins.edit,admin');
    });


    // Category
    Route::get('category', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('category.index')->middleware('permission:category,admin');

    // Products
    Route::prefix('products')->name('products.')->middleware('permission:products,admin')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('edit');
    });

    // Address
    Route::middleware('permission:address,admin')->group(function () {
        Route::get('district', [App\Http\Controllers\Admin\Address\AddressController::class, 'district'])->name('district.index');
        Route::get('thana', [App\Http\Controllers\Admin\Address\AddressController::class, 'thana'])->name('thana.index');
        Route::get('city', [App\Http\Controllers\Admin\Address\AddressController::class, 'city'])->name('city.index');
    });



    // Cancel reason
    Route::get('cancel-reason', [App\Http\Controllers\Admin\CancelReasonController::class, 'index'])->name('reason.index')->middleware('permission:others,admin');
    // Power company
    Route::get('power-company', [App\Http\Controllers\Admin\PowerCompanyController::class, 'index'])->name('power.index')->middleware('permission:others,admin');
    // prize
    Route::get('prize', [App\Http\Controllers\Admin\PrizeController::class, 'index'])->name('prize.index')->middleware('permission:prize,admin');

    // Delivery status
    Route::get('delivery-status', [App\Http\Controllers\Admin\DeliverStatusController::class, 'index'])->name('deliverystatus.index')->middleware('permission:others,admin');


    // Notification
    Route::get('notifications/{id}', [App\Http\Controllers\Admin\NotificationController::class, 'show'])->name('notification.show');


    Route::prefix('customer')->name('customer.')->middleware('permission:customer,admin')->group(function () {
        // Customer
        Route::get('/', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('index');
        Route::get('/{id}', [App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('show');
    });


    // Coupon
    Route::get('coupon', [App\Http\Controllers\Admin\CouponController::class, 'index'])->name('coupon.index')->middleware('permission:cupon,admin');


    Route::prefix('orders')->name('order.')->middleware('permission:orders,admin')->group(function () {
        // Orders
        Route::get('product', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('product.index');
        Route::get('product/{id}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('product.show');
        Route::get('product/download/{id}', [App\Http\Controllers\Admin\OrderController::class, 'download'])->name('product.download');


        // Custom order
        Route::get('custom', [App\Http\Controllers\Admin\CustomOrderController::class, 'index'])->name('customorder.index');
        Route::get('custom/{id}', [App\Http\Controllers\Admin\CustomOrderController::class, 'show'])->name('customorder.show');

        // Medicine order
        Route::get('medicine', [App\Http\Controllers\Admin\MedicineOrderController::class, 'index'])->name('medicine.index');
        Route::get('medicine/{id}', [App\Http\Controllers\Admin\MedicineOrderController::class, 'show'])->name('medicine.show');

        // Electricity bill
        Route::get('electricity-bill', [App\Http\Controllers\Admin\ElectricitybillController::class, 'index'])->name('electricity.index');
        Route::get('electricity-bill/{id}', [App\Http\Controllers\Admin\ElectricitybillController::class, 'show'])->name('electricity.show');
    });


    Route::prefix('wallet')->name('wallet.')->middleware('permission:wallet,admin')->group(function () {
        // Wallet Package
        Route::get('package', [App\Http\Controllers\Admin\WalletpackageController::class, 'index'])->name('package.index');

        // Wallet users
        Route::get('users', [App\Http\Controllers\Admin\Wallet\UserController::class, 'index'])->name('user.index');
        Route::get('users/{id}', [App\Http\Controllers\Admin\Wallet\UserController::class, 'show'])->name('user.show');

        // Wallet requests
        Route::get('request', [App\Http\Controllers\Admin\Wallet\RequestController::class, 'index'])->name('request.index');

        // package application
        Route::get('package/application', [App\Http\Controllers\Admin\Wallet\PackageController::class, 'index'])->name('application.index');
        Route::get('package/application/{id}', [App\Http\Controllers\Admin\Wallet\PackageController::class, 'show'])->name('application.show');
    });



    Route::group(['prefix' => 'percentage', 'as' => 'percentage.', 'middleware' => 'permission:percentage,admin'], function () {
        // Developer Management
        Route::get('developer', [App\Http\Controllers\Admin\DeveloperController::class, 'index'])->name('developer.index');

        // Marketer Management
        Route::get('marketer', [App\Http\Controllers\Admin\MarketerController::class, 'index'])->name('marketer.index');
    });

    // Reports
    Route::middleware('permission:report,admin')->group(function () {
        Route::get('sale-report', [App\Http\Controllers\Admin\Report\SaleReportController::class, 'index'])->name('sale.report.index');
        Route::get('sale-report/search', [App\Http\Controllers\Admin\Report\SaleReportController::class, 'search'])->name('sale.report.search');
    });

    // User prize
    Route::get('user-prize', [App\Http\Controllers\Admin\UserPrizeController::class, 'index'])->name('userprize.index')->middleware('permission:prize,admin');

    // Withdraw
    Route::get('user-withdraw', [App\Http\Controllers\Admin\WithdrawController::class, 'index'])->name('withdraw.index')->middleware('permission:wallet,admin');


    // website
    Route::prefix('website')->name('website.')->group(function () {
        // Banner
        Route::get('banner', [App\Http\Controllers\Admin\BannerController::class, 'index'])->name('banner.index')->middleware('permission:banner,admin');

        // Settings
        Route::get('setting', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('setting.index')->middleware('permission:setting,admin');

        Route::get('faq', [App\Http\Controllers\Admin\FaqController::class, 'index'])->name('faq.index')->middleware('permission:setting,admin');
        Route::get('team', [App\Http\Controllers\Admin\TeamController::class, 'index'])->name('team.index')->middleware('permission:setting,admin');
    });
});
