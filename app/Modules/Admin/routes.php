<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/12/2020
 * Time: 2:07 PM
 */


use App\Modules\Admin\Controllers\AdminLogin;
use App\Modules\Admin\Controllers\BillController;
use App\Modules\Admin\Controllers\CommentController;
use App\Modules\Admin\Controllers\CustomerController;
use App\Modules\Admin\Controllers\ImageController;
use App\Modules\Admin\Controllers\OrderController;
use App\Modules\Admin\Controllers\ReportController;
use App\Modules\Admin\Controllers\SBillController;
use App\Modules\Admin\Controllers\SOrderController;
use App\Modules\Admin\Controllers\SReportController;
use App\Modules\Admin\Controllers\SStorageController;
use App\Modules\Admin\Controllers\StorageController;
use App\Modules\Admin\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

// Router positions
Route::middleware(['web'])->group(function () {
    Route::group(['prefix' => 'admin', 'namespace'=>'App\Modules\Admin\Controllers'], function () {
        Route::get('login', [AdminLogin::class, 'index']);
        Route::get('get-image/{id}', [ImageController::class, 'getImage'])->name('get-image');
        Route::get('get-image-resource/{resource?}', [ImageController::class, 'getImageResource'])
            ->name('get-image-resource')->where('resource', '(.*)');
        Route::get('get-image-thumbnail/{id}', [ImageController::class, 'getImageThumbnail'])->name('get-image-thumbnail');
        Route::post('images-destroy', [ImageController::class, 'imagesDestroy'])->name('images-destroy');
    });
});

Route::middleware(['web','admin'])->group(function () {
    Route::group(['prefix' => 'admin', 'namespace'=>'App\Modules\Admin\Controllers'], function ()  {
        Route::resource('dashboard', 'DashboardController');
        Route::resource('products', 'ProductController');
        Route::resource('product-categories', 'ProductCategoryController');
        Route::resource('images', 'ImageController');
        Route::resource('sliders', 'SliderController');
        Route::resource('banners', 'BannerController');
        Route::resource('comments', 'CommentController');
        Route::resource('menus', 'MenuController');
        Route::resource('producers', 'ProducerController');
        Route::resource('suppliers', 'SupplierController');
        Route::resource('users', 'UserController');

        Route::resource('posts', 'PostController');
        Route::resource('post-categories', 'PostCategoryController');
        Route::resource('news', 'NewsController');
        Route::resource('sites', 'SiteController');
        Route::resource('pages', 'PageController');
        Route::resource('contacts', 'ContactController');
        Route::resource('order-status', 'OrderStatusController');
        Route::resource('orders', 'OrderController');
        Route::resource('product-option', 'ProductOptionController');

        Route::post('update-payment', [OrderController::class, 'updatePayment'])->name('update-payment');
        Route::post('confirm-payment', [OrderController::class, 'confirmPayment'])->name('confirm-payment');
        Route::get('orders-detail/{id}', [OrderController::class, 'detail'])->name('orders-detail');
        Route::get('orders-invoice/{id}', [OrderController::class, 'invoice'])->name('orders-invoice');
        Route::get('orders-payment', [OrderController::class, 'payment'])->name('orders-payment');
        Route::get('storages', [StorageController::class, 'index'])->name('storages.index');
        Route::get('bills', [BillController::class, 'index'])->name('bills.index');
        Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    });
});

Route::middleware(['web','shop'])->group(function () {
    Route::group(['prefix' => 'admin', 'namespace'=>'App\Modules\Admin\Controllers'], function ()  {
        Route::resource('board', 'SBoardController');
        Route::resource('product', 'SProductController');
        Route::resource('order', 'SOrderController')->except(['create']);
        
        Route::post('update-spayment', [SOrderController::class, 'updatePayment'])->name('update-spayment');
        Route::post('reply-comment', [CommentController::class, 'reply'])->name('reply-comment');
        Route::post('report-comment', [CommentController::class, 'report'])->name('report-comment');
        Route::get('order-detail/{id}', [SOrderController::class, 'detail'])->name('order-detail');
        Route::get('order-invoice/{id}', [SOrderController::class, 'invoice'])->name('order-invoice');
        Route::get('order-payment', [SOrderController::class, 'payment'])->name('order-payment');
        Route::get('storage', [SStorageController::class, 'index'])->name('storage.index');
        Route::get('bill', [SBillController::class, 'index'])->name('bill.index');
        Route::get('report', [SReportController::class, 'index'])->name('report.index');
        Route::get('shop', [SupplierController::class, 'setup'])->name('shop.setup');
    });
});
