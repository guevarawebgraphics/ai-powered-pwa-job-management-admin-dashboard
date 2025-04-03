<?php

use Illuminate\Http\Request;

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

/* chat */
Route::get('/chats/{fromId?}/{toId?}',
    ['as' => 'chat.index',
        'uses' => '\App\Http\Controllers\ChatController@index']
);
Route::get('/chat-listing/{currentUserId?}',
    ['as' => 'chat.get',
        'uses' => '\App\Http\Controllers\ChatController@getChatUsers']
);
Route::post('/store/chat',
    ['as' => 'chat.store',
        'uses' => '\App\Http\Controllers\ChatController@store']
);
/* chat */


Route::prefix('firebase')->group(function () {
    Route::post('/store', [App\Http\Controllers\ChatController::class, 'storeFirebaseToken']);
    Route::post('/notification', [App\Http\Controllers\ChatController::class, 'callFirebaseNotification']);
});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

