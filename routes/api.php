<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\SneakersController;
use App\Http\Controllers\api\SizesController;
use App\Http\Controllers\api\BrandsController;
use App\Http\Controllers\api\UsersController;

Route::prefix('adrian')->group(function () {

    Route::get('sneakers', [SneakersController::class, 'index']);
    Route::get('sneakers/{id}', [SneakersController::class, 'show']);
    Route::post('sneakers', [SneakersController::class, 'store']);
    Route::put('sneakers/{id}', [SneakersController::class, 'update']);
    Route::delete('sneakers/{id}', [SneakersController::class, 'destroy']);
    Route::get('sneakers/brand/{brand_id}', [SneakersController::class, 'indexByBrand']);
    Route::get('sneakers/size/{size_id}', [SneakersController::class, 'indexBySize']);
    Route::post('sneakers/filter', [SneakersController::class, 'filter']);

    Route::get('sizes', [SizesController::class, 'index']);
    Route::get('sizes/{id}', [SizesController::class, 'show']);
    Route::post('sizes', [SizesController::class, 'store']);
    Route::put('sizes/{id}', [SizesController::class, 'update']);
    Route::delete('sizes/{id}', [SizesController::class, 'destroy']);

    Route::get('brands', [BrandsController::class, 'index']);
    Route::get('brands/{id}', [BrandsController::class, 'show']);
    Route::post('brands', [BrandsController::class, 'store']);
    Route::put('brands/{id}', [BrandsController::class, 'update']);
    Route::delete('brands/{id}', [BrandsController::class, 'destroy']);

    Route::get('users', [UsersController::class, 'index']);
    Route::get('users/{id}', [UsersController::class, 'show']);
    Route::post('users', [UsersController::class, 'store']);
    Route::put('users/{id}', [UsersController::class, 'update']);
    Route::delete('users/{id}', [UsersController::class, 'destroy']);

});
