<?php

use App\Http\Controllers\Api\Site\ProductController;
use App\Http\Controllers\Api\Site\AuthController;
use Illuminate\Support\Facades\Route;


Route::
    prefix('site')
    ->namespace('Api\Site')
    ->group(function(){
        Route::post('login',[AuthController::class,'login']);
        Route::post('register',[AuthController::class,'register']);
        Route::post('verify-account',[AuthController::class,'verifyAccount']);
        Route::post('resend-otp',[AuthController::class,'resendOtp']);

        Route::middleware(['auth:sanctum','abilities:user'])->group(function(){

            Route::get('logout',[AuthController::class,'logout']);

            // Products
            Route::get('products',[ProductController::class,'index']);
            Route::get('products/{id}',[ProductController::class,'show']);
        });


    });
