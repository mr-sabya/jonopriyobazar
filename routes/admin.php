<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\WalletpackageController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\Customer\ReferbalanceController;
use App\Http\Controllers\Admin\Customer\PointController;
use App\Http\Controllers\Admin\Customer\ReferController;
use App\Http\Controllers\Admin\DeliverStatusController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CancelReasonController;
use App\Http\Controllers\Admin\PowerCompanyController;
use App\Http\Controllers\Admin\Wallet\PackageController;
use App\Http\Controllers\Admin\DeveloperController;
use App\Http\Controllers\Admin\MarketerController;
use App\Http\Controllers\Admin\Report\SaleReportController;
use App\Http\Controllers\Admin\PrizeController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\UserPrizeController;
use App\Http\Controllers\Admin\WithdrawController;


// Login
Route::get('login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');


Route::middleware(['auth:admin'])->group(function () {

    // Error page
    Route::get('404', [App\Http\Controllers\Admin\ErrorController::class, 'error404'])->name('error.404');

    // Dashboard
    Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('dashboard');

    // Permissions
    Route::get('permissions', [App\Http\Controllers\Admin\PermissionController::class, 'index'])->name('permissions.index');

    // Roles
    Route::get('roles', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles.index');

    // Admins
    Route::prefix('admins')->name('admins.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\AdminController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\AdminController::class, 'edit'])->name('edit');
    });


    // Category
    Route::get('category', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('category.index');

    // Products
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('edit');
    });

    // Address
    Route::get('district', [App\Http\Controllers\Admin\Address\AddressController::class, 'district'])->name('district.index');
    Route::get('thana', [App\Http\Controllers\Admin\Address\AddressController::class, 'thana'])->name('thana.index');
    Route::get('city', [App\Http\Controllers\Admin\Address\AddressController::class, 'city'])->name('city.index');


    // Banner
    Route::resource('banner', BannerController::class, ['names' => 'banner']);


    // Settings
    Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('setting/update', [SettingController::class, 'update'])->name('setting.update');

    // Cancel reason
    Route::get('cancel-reason', [App\Http\Controllers\Admin\CancelReasonController::class, 'index'])->name('reason.index');
    // Power company
    Route::get('power-company', [App\Http\Controllers\Admin\PowerCompanyController::class, 'index'])->name('power.index');
    // prize
    Route::get('prize', [App\Http\Controllers\Admin\PrizeController::class, 'index'])->name('prize.index');


    // Notification
    Route::get('notifications/{id}', [NotificationController::class, 'show'])->name('notification.show');

    // Customer
    Route::get('customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('customer/{id}', [CustomerController::class, 'show'])->name('customer.show');
    Route::get('fetch-order/{id}', [CustomerController::class, 'fetchOrder']);

    // Refer / point history
    Route::get('user/refer/history/{id}', [ReferbalanceController::class, 'index'])->name('referhistory.index');
    Route::get('user/point/history/{id}', [PointController::class, 'index'])->name('pointhistory.index');

    // Refer customer
    Route::get('customer/refer/{id}', [ReferController::class, 'index'])->name('customerrefer.index');
    Route::get('customer/status/refer/{id}', [CustomerController::class, 'referStatus'])->name('referpercentage.status');

    // Coupon
    Route::get('coupon', [App\Http\Controllers\Admin\CouponController::class, 'index'])->name('coupon.index');

    // Delivery status
    Route::resource('delivery-status', DeliverStatusController::class, ['names' => 'deliverystatus', 'except' => ['update']]);
    Route::post('delivery-status/update', [DeliverStatusController::class, 'update'])->name('deliverystatus.update');



    Route::prefix('orders')->name('order.')->group(function () {
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


    Route::prefix('wallet')->name('wallet.')->group(function () {
        // Wallet Package
        Route::get('package', [App\Http\Controllers\Admin\WalletpackageController::class, 'index'])->name('package.index');

        // Wallet users
        Route::get('users', [App\Http\Controllers\Admin\Wallet\UserController::class, 'index'])->name('user.index');
        Route::get('users/{id}', [App\Http\Controllers\Admin\Wallet\UserController::class, 'show'])->name('user.show');

        // Wallet requests
        Route::get('request', [App\Http\Controllers\Admin\Wallet\RequestController::class, 'index'])->name('request.index');
    });




    // Wallet package applications
    Route::get('wallet/package/application', [PackageController::class, 'index'])->name('packageapplication.index');
    Route::get('wallet/package/application/{id}', [PackageController::class, 'show'])->name('packageapplication.show');
    Route::get('wallet/package/approve/{id}', [PackageController::class, 'approveWallet'])->name('packageapplication.approve');
    Route::delete('wallet/package/application/{id}', [PackageController::class, 'delete'])->name('packageapplication.delete');
    Route::post('wallet/package/assign', [PackageController::class, 'assign'])->name('walletpackage.assign');
    Route::post('wallet/package/change', [PackageController::class, 'changePackage'])->name('walletpackage.change');

    // Developer
    Route::get('developer/percentage', [DeveloperController::class, 'index'])->name('developer.index');
    Route::get('developer/fetch-percentage', [DeveloperController::class, 'fetchPercentage'])->name('developer.fetch');
    Route::get('developer/fetch-withdraw', [DeveloperController::class, 'fetchWithdraw'])->name('developerwithdraw.fetch');
    Route::post('developer/withdraw/store', [DeveloperController::class, 'store'])->name('developerwithdraw.store');
    Route::delete('developer/withdraw/{id}', [DeveloperController::class, 'destroy'])->name('developerwithdraw.destroy');

    // Marketer
    Route::get('marketer/percentage', [MarketerController::class, 'index'])->name('marketer.index');
    Route::get('marketer/fetch-percentage', [MarketerController::class, 'fetchPercentage'])->name('marketer.fetch');
    Route::get('marketer/fetch-withdraw', [MarketerController::class, 'fetchWithdraw'])->name('marketerwithdraw.fetch');
    Route::post('marketer/withdraw/store', [MarketerController::class, 'store'])->name('marketerwithdraw.store');
    Route::delete('marketer/withdraw/{id}', [MarketerController::class, 'destroy'])->name('marketerwithdraw.destroy');

    // Reports
    Route::get('sale-report', [SaleReportController::class, 'index'])->name('sale.report.index');
    Route::get('sale-report/search', [SaleReportController::class, 'search'])->name('sale.report.search');

    // Prize / FAQ / Team

    Route::resource('faq', FaqController::class, ['names' => 'faq']);
    Route::resource('team', TeamController::class, ['names' => 'team']);

    // User prize
    Route::get('user-prize', [UserPrizeController::class, 'index'])->name('userprize.index');
    Route::get('user-prize/update/{id}', [UserPrizeController::class, 'update'])->name('userprize.update');

    // Withdraw
    Route::get('user-withdraw', [WithdrawController::class, 'index'])->name('withdraw.index');
    Route::get('user-withdraw/update/{id}', [WithdrawController::class, 'update'])->name('withdraw.update');
});
