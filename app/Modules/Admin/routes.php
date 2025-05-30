<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/12/2020
 * Time: 2:07 PM
 */

use App\Modules\Admin\Controllers\AdminLogin;
use App\Modules\Admin\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

// Router positions
Route::middleware(['web'])->group(function () {
    Route::group(['prefix' => 'admin', 'namespace'=>'App\Modules\Admin\Controllers'], function () {
        Route::resource('login', AdminLogin::class);
        Route::get('get-image/{id}', [ImageController::class, 'getImage'])->name('get-image');
        Route::get('get-image-resource/{resource?}', [ImageController::class, 'getImageResource'])
            ->name('get-image-resource')->where('resource', '(.*)');;
        Route::get('get-image-thumbnail/{id}', [ImageController::class, 'getImageThumbnail'])->name('get-image-thumbnail');
        Route::post('images-destroy', [ImageController::class, 'imagesDestroy'])->name('images-destroy');
    });
});

Route::middleware(['web','admin'])->group(function () {
    Route::group(['prefix' => 'admin', 'middleware' => ['auth'], 'namespace'=>'App\Modules\Admin\Controllers'], function ()  {
        Route::resource('dashboard', 'DashboardController');
        Route::resource('products', 'ProductController');
        Route::resource('product-categories', 'ProductCategoryController');
        Route::resource('images', 'ImageController');
        Route::resource('sliders', 'SliderController');
        Route::resource('banners', 'BannerController');
        Route::resource('menus', 'MenuController');
        Route::resource('producer', 'ProducerController');
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
    });
});
