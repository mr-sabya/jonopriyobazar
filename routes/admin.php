<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\ErrorController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\Address\DistrictController;
use App\Http\Controllers\Admin\Address\ThanaController;
use App\Http\Controllers\Admin\Address\CityController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\WalletpackageController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\Customer\ReferbalanceController;
use App\Http\Controllers\Admin\Customer\PointController;
use App\Http\Controllers\Admin\Customer\ReferController;
use App\Http\Controllers\Admin\CuponController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderHistoryController;
use App\Http\Controllers\Admin\DeliverStatusController;
use App\Http\Controllers\Admin\CustomOrderController;
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Admin\ElectricitybillController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CancelReasonController;
use App\Http\Controllers\Admin\PowerCompanyController;
use App\Http\Controllers\Admin\Wallet\UserController as WalletUserController;
use App\Http\Controllers\Admin\Customer\PaymentController;
use App\Http\Controllers\Admin\Customer\WalletController;
use App\Http\Controllers\Admin\Wallet\RequestController;
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
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login/submit', [LoginController::class, 'login'])->name('login.submit');


Route::middleware(['auth:admin'])->group(function () {

    // Error page
    Route::get('404', [ErrorController::class, 'error404'])->name('error.404');

    // Logout
    Route::post('logout/submit', [LoginController::class, 'logout'])->name('logout.submit');

    // Dashboard
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    // Permissions
    Route::resource('permissions', PermissionController::class, ['names' => 'permissions', 'except' => ['update']]);
    Route::post('permissions/update', [PermissionController::class, 'update'])->name('permissions.update');

    // Roles
    Route::resource('roles', RoleController::class, ['names' => 'roles']);

    // Admins
    Route::resource('admins', AdminController::class, ['names' => 'admins']);

    // Category
    Route::resource('category', CategoryController::class, ['names' => 'category']);

    // Products
    Route::resource('products', ProductController::class, ['names' => 'products']);

    // District
    Route::resource('district', DistrictController::class, ['names' => 'district', 'except' => ['update', 'destroy']]);
    Route::post('district/update', [DistrictController::class, 'update'])->name('district.update');
    Route::get('district/delete/{id}', [DistrictController::class, 'destroy'])->name('district.destroy');
    Route::get('get-district', [DistrictController::class, 'getDistrict'])->name('district.get');

    // Thana
    Route::resource('thana', ThanaController::class, ['names' => 'thana', 'except' => ['update', 'destroy']]);
    Route::post('thana/update', [ThanaController::class, 'update'])->name('thana.update');
    Route::get('thana/delete/{id}', [ThanaController::class, 'destroy'])->name('thana.destroy');
    Route::get('get-thana/{id}', [CityController::class, 'getThana']);

    // City
    Route::resource('city', CityController::class, ['names' => 'city', 'except' => ['update', 'destroy']]);
    Route::post('city/update', [CityController::class, 'update'])->name('city.update');
    Route::get('city/delete/{id}', [CityController::class, 'destroy'])->name('city.destroy');

    // Banner
    Route::resource('banner', BannerController::class, ['names' => 'banner']);

    // Wallet Package
    Route::resource('wallet-package', WalletpackageController::class, ['names' => 'walletpackage', 'except' => ['update']]);
    Route::post('wallet-package/update', [WalletpackageController::class, 'update'])->name('walletpackage.update');

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
    Route::resource('cupon', CuponController::class, ['names' => 'cupon', 'except' => ['update']]);
    Route::post('cupon/update', [CuponController::class, 'update'])->name('cupon.update');

    // Orders
    Route::get('orders', [OrderController::class, 'index'])->name('order.index');
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::get('order/download/{id}', [OrderController::class, 'download'])->name('order.download');

    // Order history
    Route::get('order/history/{id}', [OrderHistoryController::class, 'index'])->name('orderhistory.index');
    Route::post('order/history/create', [OrderHistoryController::class, 'store'])->name('orderhistory.store');

    // Delivery status
    Route::resource('delivery-status', DeliverStatusController::class, ['names' => 'deliverystatus', 'except' => ['update']]);
    Route::post('delivery-status/update', [DeliverStatusController::class, 'update'])->name('deliverystatus.update');

    // Custom order
    Route::get('custom-order', [CustomOrderController::class, 'index'])->name('customorder.index');
    Route::get('custom-order/{id}', [CustomOrderController::class, 'show'])->name('customorder.show');
    Route::post('custom-order/update', [CustomOrderController::class, 'update'])->name('customorder.update');
    Route::post('custom-order/payment/update', [CustomOrderController::class, 'changePayment'])->name('customorder.updatepayment');

    // Medicine order
    Route::get('medicine-order', [MedicineController::class, 'index'])->name('medicine.index');
    Route::get('medicine-order/{id}', [MedicineController::class, 'show'])->name('medicine.show');
    Route::post('medicine-order/update', [MedicineController::class, 'update'])->name('medicine.update');
    Route::post('medicine-order/payment/update', [MedicineController::class, 'changePayment'])->name('medicine.updatepayment');

    // Electricity bill
    Route::get('electricity-bill', [ElectricitybillController::class, 'index'])->name('electricity.index');
    Route::get('electricity-bill/{id}', [ElectricitybillController::class, 'show'])->name('electricity.show');

    // Get delivery status
    Route::get('get-delivery-status', [OrderController::class, 'getStatus'])->name('get.deliverstatus');

    // Settings
    Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('setting/update', [SettingController::class, 'update'])->name('setting.update');

    // Cancel reason
    Route::resource('cancel-reason', CancelReasonController::class, ['names' => 'reason', 'except' => ['update']]);
    Route::post('cancel-reason/update', [CancelReasonController::class, 'update'])->name('reason.update');

    // Power company
    Route::resource('power-company', PowerCompanyController::class, ['names' => 'power', 'except' => ['update']]);
    Route::post('power-company/update', [PowerCompanyController::class, 'update'])->name('power.update');

    // Wallet users
    Route::get('wallet/users', [WalletUserController::class, 'index'])->name('walletuser.index');
    Route::get('wallet/users/{id}', [WalletUserController::class, 'show'])->name('walletuser.show');
    Route::get('user/purchase/history/{id}', [WalletUserController::class, 'getPurachase']);
    Route::get('user/pay/history/{id}', [WalletUserController::class, 'getPay']);

    // Payments
    Route::post('user/payments/store', [PaymentController::class, 'store'])->name('payment.store');

    // Wallet extend / approve / hold
    Route::post('wallet/package/extend', [WalletController::class, 'extendPackage'])->name('walletpackage.extend');
    Route::get('wallet/approve/{id}', [WalletController::class, 'approve'])->name('wallet.approve');
    Route::get('wallet/hold/{id}', [WalletController::class, 'hold'])->name('wallet.hold');
    Route::get('wallet/re-active/{id}', [WalletController::class, 'reactive'])->name('wallet.reactive');

    // Wallet requests
    Route::get('wallet-request', [RequestController::class, 'index'])->name('walletrequest.index');
    Route::get('wallet-request/{id}', [RequestController::class, 'show'])->name('walletrequest.show');

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
    Route::resource('prize', PrizeController::class, ['names' => 'prize']);
    Route::resource('faq', FaqController::class, ['names' => 'faq']);
    Route::resource('team', TeamController::class, ['names' => 'team']);

    // User prize
    Route::get('user-prize', [UserPrizeController::class, 'index'])->name('userprize.index');
    Route::get('user-prize/update/{id}', [UserPrizeController::class, 'update'])->name('userprize.update');

    // Withdraw
    Route::get('user-withdraw', [WithdrawController::class, 'index'])->name('withdraw.index');
    Route::get('user-withdraw/update/{id}', [WithdrawController::class, 'update'])->name('withdraw.update');
});
