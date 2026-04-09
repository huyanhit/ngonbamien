<?php

use App\Modules\Chat\Controllers\CboxController;
use App\Modules\Chat\Controllers\ChatController;
use App\Modules\Chat\Controllers\CommentController;
use App\Modules\Chat\Controllers\FileController;
use App\Modules\Chat\Controllers\MemberController;
use App\Modules\Chat\Controllers\MessageController;
use App\Modules\Chat\Controllers\ReactionController;
use App\Modules\Chat\Controllers\RoomController;
use App\Modules\Chat\Controllers\ContactController;
use App\Modules\Chat\Controllers\FileCboxController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/get-auth', [ChatController::class, 'getAuth']);
    Route::group(['prefix' => '/chat'], function (){
        Route::get('/get-file-thumbnail/{id}', [FileController::class, 'getFileThumbnail']);
        Route::get('/get-file-raw/{id}', [FileController::class, 'getFileRaw']);
        Route::get('/get-user/{type}', [ContactController::class, 'getUser']);
        Route::get('/get-my-rooms', [RoomController::class, 'getMyRooms']);
        Route::get('/get-module-room', [RoomController::class, 'getModuleRoom']);
        Route::get('/comment-room/{id}', [CommentController::class, 'getRoom']);
        Route::get('/contact-guests', [ContactController::class, 'getAllGuest']);

        Route::post('/create-module-room', [RoomController::class, 'createModuleRoom']);
        Route::post('/update-module-room', [RoomController::class, 'updateModuleRoom']);
        Route::post('/set-unread', [MemberController::class, 'setUnread']);
        Route::post('/join-room', [RoomController::class, 'joinRoom']);

        Route::post('/contact/approve', [ContactController::class, 'approve']);
        Route::post('/contact/request', [ContactController::class, 'request']);
        Route::post('/contact/un-request', [ContactController::class, 'unRequest']);
        Route::post('/contact/cancel', [ContactController::class, 'cancel']);
        Route::post('/contact/remove', [ContactController::class, 'remove']);

        Route::resource('/room', RoomController::class);
        Route::resource('/comment', CommentController::class);
        Route::resource('/message', MessageController::class);
        Route::resource('/contact', ContactController::class);
        Route::resource('/file', FileController::class);
        Route::resource('/reaction', ReactionController::class);
    });
});

Route::middleware(['web', 'admin'])->group(function () {
    Route::group(['prefix' => 'chat', 'middleware' => ['auth'], 'namespace'=>'App\Modules\Chat\Controllers'], function ()  {
        Route::get('/', [ChatController::class, 'index'])->name('chat');
        Route::get('/{any}', [ChatController::class, 'index'])->where('any', '.*')->name('chat-page');
    });
});

Route::post('/cbox/create-cbox', [CboxController::class, 'createCbox']);
Route::get('/cbox/get-product', [CboxController::class, 'getProduct']);
Route::middleware(['cbox'])->group( function () {
    Route::group(['prefix' => 'cbox'], function (){
        Route::get('/cbox', [CboxController::class, 'getCbox']);
        Route::get('/cbox-data', [CboxController::class, 'getCboxData']);
        Route::get('/get-file-thumbnail/{id}', [FileController::class, 'getFileThumbnail']);
        Route::get('/get-file-raw/{id}', [FileController::class, 'getFileRaw']);
        Route::post('/set-unread', [CboxController::class, 'setUnread']);
        Route::post('/message-command', [CboxController::class, 'messageCommand']);
        Route::resource('/message', CboxController::class)->names('cbox-message');
        Route::resource('/file', FileCboxController::class)->names('cbox-file');
        Route::resource('/reaction', ReactionController::class)->names('cbox-reaction');
    });
});