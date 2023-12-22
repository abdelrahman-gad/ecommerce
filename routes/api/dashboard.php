<?php


use App\Http\Controllers\Api\Dashboard\AuthController;
use App\Http\Controllers\Api\Dashboard\ProductController;
use Illuminate\Support\Facades\Route;


Route::
    prefix('dashboard')
    ->namespace('Api\Dashboard')
    ->group(function(){
        Route::post('login',[AuthController::class,'login']);

        Route::middleware(['auth:sanctum','abilities:admin'])->group(function(){
            //product routes resource all excep create and edit and update

            Route::get('products',[ProductController::class,'index']);
            Route::post('products',[ProductController::class,'store']);
            Route::get('products/{id}',[ProductController::class,'show']);
            Route::delete('products/{id}',[ProductController::class,'destroy']);
            // route for update product


        });
    });
