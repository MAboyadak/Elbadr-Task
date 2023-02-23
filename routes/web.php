<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\EmailVerificationController;
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

Route::get('/',function(){
    return redirect()->route('users.index');
});

Auth::routes();

Route::group(['middleware'=>'auth'], function(){
    Route::resource('users',UsersController::class);
    Route::get('toggle-activation/{id}',[UsersController::class,'toggleActivation'])->name('toggle-activation');
    Route::get('verify-email',[EmailVerificationController::class,'show'])->name('verify.show');
    Route::post('email-verify',[EmailVerificationController::class,'verifyEmail'])->name('verify.update');
    Route::post('email-resend',[EmailVerificationController::class,'resendOtp'])->name('verify.resend');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
