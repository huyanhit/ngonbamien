<?php
use Illuminate\Support\Facades\Route;
use App\Modules\Notification\Controllers\NotificationController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix' => '/notification'], function (){
        Route::get('summary', [NotificationController::class, 'summary']);
        Route::get('setting-default', [NotificationController::class, 'settingDefault']);
        Route::get('setting-by-object', [NotificationController::class, 'settingByObject']);
        Route::put('update-setting/{id}', [NotificationController::class, 'updateSetting']);
        Route::resource('notification', NotificationController::class);
    });
});
