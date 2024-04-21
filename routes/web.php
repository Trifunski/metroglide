<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::view('/', 'Welcome');
Route::view('/about', 'About');
Route::view('/contact', 'Contact');
Route::view('/SneakerView', 'SneakerView');
Route::view('/SneakerExplorer', 'SneakerExplorer');
Route::view('/login', 'Login');
Route::view('/cart', 'Cart');

Route::post('/login', [AuthController::class, 'login']);
Route::get('/check-token', [AuthController::class, 'checkToken']);
Route::get('/logout', [AuthController::class, 'logout']);