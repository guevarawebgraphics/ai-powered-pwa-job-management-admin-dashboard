<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/* OTP */

Route::prefix('otp')->group(function () {
    Route::get('/', [App\Http\Controllers\PageController::class, 'indexOtp'])->name('otp.index');
    Route::post('/send', [App\Http\Controllers\PageController::class, 'otpSend'])->name('otp.send');
    Route::post('/store', [App\Http\Controllers\PageController::class, 'otpStore'])->name('otp.store');
});

/* OTP */
Route::get('/', function () {
    return redirect('/admin/dashboard');
});
