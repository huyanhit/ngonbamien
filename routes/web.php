<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('artisan/{command}', function ($command){
    Artisan::call($command);
    return Artisan::output();
});

Route::middleware('auth')->group(function () {
    Route::get('/dang-xuat', [AuthenticatedSessionController::class, 'destroy'])->name('auth.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
    ->name('ckfinder_connector');
Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
    ->name('ckfinder_browser');

// ajax
Route::get('/ax-find-product', [ProductController::class, 'productCategory'])->name('ajax-find-product');
Route::get('/ax-load-comment', [CommentController::class, 'loadComment'])->name('ajax-load-comment');
Route::post('/ax-comment', [CommentController::class, 'comment'])->name('ajax-comment');
Route::post('/ax-post-comment', [CommentController::class, 'postComment'])->name('ajax-post-comment');
Route::post('/favor', [ProductController::class, 'favor'])->name('favor');
Route::get('/counter', [HomeController::class, 'counter'])->name('page.counter');
Route::resource('/cart', CartController::class);
require __DIR__.'/auth.php';

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/phan-loai/{slug}', [CategoryProductController::class, 'show'])->name('phan-loai');
Route::get('/cua-hang/{slug?}', [ProductController::class, 'index'])->name('cua-hang');
Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('san-pham');
Route::get('/bai-viet/{slug?}', [PostController::class, 'index'])->name('bai-viet');
Route::get('/noi-dung/{slug}', [PostController::class, 'show'])->name('noi-dung');
Route::get('/vung-mien/{slug}', [ProducerController::class, 'show'])->name('vung-mien');
Route::get('/don-hang', [OrderController::class, 'search'])->name('don-hang');
Route::get('/gio-hang', [CartController::class, 'page'])->name('gio-hang');
Route::post('/gio-hang', [CartController::class, 'coupon'])->name('coupon');
Route::get('/dat-hang', [CheckController::class, 'index'])->name('dat-hang');
Route::post('/mua-hang', [OrderController::class, 'store'])->name('mua-hang');
Route::get('/thanh-toan/{code}', [OrderController::class, 'show'])->name('thanh-toan');
Route::put('/thanh-toan/{code}', [OrderController::class, 'update'])->name('tat-toan');
Route::get('/tim-kiem',   [SearchController::class, 'search'])->name('tim-kiem');
Route::get('/yeu-thich', [ProductController::class, 'favors'])->name('yeu-thich');
Route::get('/khuyen-mai', [ProductController::class, 'promotion'])->name('khuyen-mai');

Route::get('/lien-he', [PageController::class, 'contact'])->name('lien-he');
Route::get('/{page}', [PageController::class, 'show'])->name('xem-trang');



