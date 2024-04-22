<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;

/* Views */
Route::view('/', 'Welcome');
Route::view('/about', 'About');
Route::view('/contact', 'Contact');
Route::view('/SneakerView', 'SneakerView');
Route::view('/SneakerExplorer', 'SneakerExplorer');
Route::view('/login', 'Login');
Route::view('/cart', 'Cart');

/* User */
Route::post('/login', [AuthController::class, 'login']);
Route::get('/check-token', [AuthController::class, 'checkToken']);
Route::get('/logout', [AuthController::class, 'logout']);

/* Cart */
Route::post('/cart/add', [CartController::class, 'addCart']);
Route::post('/cart/remove', [CartController::class, 'removeCart']);
Route::post('/cart/update', [CartController::class, 'updateCart']);
Route::get('/cart', [CartController::class, 'getCart']);