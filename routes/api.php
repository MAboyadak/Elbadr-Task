<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\VerificationController;
use App\Http\Controllers\Auth\EmailVerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login',[AuthController::class,'Login']);
Route::post('/register',[AuthController::class,'Register']);

Route::group( ['middleware' => ['auth:sanctum']], function(){

    Route::post('/logout',[AuthController::class,'Logout']);
    Route::apiResource('users', UsersController::class);
    Route::post('email-verification', [VerificationController::class,'verifyEmail']);
    Route::post('resend-otp', [VerificationController::class,'resendOtp']);

});
