<?php


use App\Http\Controllers\Api\Dashboard\AuthController;
use App\Http\Controllers\Api\Dashboard\ProductController;
use App\Http\Controllers\Api\Dashboard\UserController;
use Illuminate\Support\Facades\Route;


Route::
    prefix('dashboard')
    ->namespace('Api\Dashboard')
    ->group(function(){
        Route::post('login',[AuthController::class,'login']);

        Route::middleware(['auth:sanctum','abilities:admin'])->group(function(){

            Route::get('logout',[AuthController::class,'logout']);


            // Products CRUD
            Route::get('products',[ProductController::class,'index']);
            Route::post('products',[ProductController::class,'store']);
            Route::post('products-update',[ProductController::class,'update']);
            Route::get('products/{id}',[ProductController::class,'show']);
            Route::delete('products/{id}',[ProductController::class,'destroy']);

            // User Types
            Route::get('user-types',[UserController::class,'listUserTypes']);
            
            // Users CRUD
            Route::get('users',[UserController::class,'index']);
            Route::post('users',[UserController::class,'store']);
            Route::post('users-update',[UserController::class,'update']);
            Route::get('users/{id}',[UserController::class,'show']);
            Route::delete('users/{id}',[UserController::class,'destroy']);

     
        });
    });
