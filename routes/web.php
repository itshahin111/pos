<?php

use App\Http\Controllers\UserController;
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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::post('/register', [UserController::class, 'registration']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/otp', [UserController::class, 'sendOtp']);
Route::post('/verify', [UserController::class, 'verifyOtp'])->middleware('auth:sanctum');

//group middleware sanctum routes
Route::get('/user/profile', [UserController::class, 'userProfile'])->middleware('auth:sanctum');
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/profile/update', [UserController::class, 'updateProfile'])->middleware('auth:sanctum');