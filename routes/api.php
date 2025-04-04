<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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

Route::get('/youtube', function () {
    $api = 'https://api.appliancerepairamerican.com/AIResponse/appliance-repair';

    $response = Http::asJson()  // <-- ensures the payload is sent as JSON
        ->post($api, [
            'query' => 'Samsung dryer model GHS9900JS11 is The machine is overheating after prolonged use.'
        ]);

    $json = json_decode($response, true);

    // Loop through the repairs array and add an 'id' field
    foreach ($json['repairs'] as $index => $repair) {
        // Assign a unique ID (here using the index plus one)
        $json['repairs'][$index]['id'] = $index + 1;
    }

    return $json['repairs'];

});



Route::prefix('firebase')->group(function () {
    Route::post('/store', [App\Http\Controllers\ChatController::class, 'storeFirebaseToken']);
    Route::post('/notification', [App\Http\Controllers\ChatController::class, 'callFirebaseNotification']);
});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

