<?php

use App\Http\Controllers\DashboardController;
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


Route::post('/user/register', [UserController::class, 'registration']);
Route::post('/user/login', [UserController::class, 'login']);
Route::post('/send/otp', [UserController::class, 'sendOtp']);
Route::post('/otp/verify', [UserController::class, 'verifyOtp']);

//group middleware sanctum routes
Route::get('/login', [UserController::class, 'loginPage']);
Route::get('/userProfile', [UserController::class, 'userProfile'])->middleware('auth:sanctum');
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/profile/update', [UserController::class, 'updateProfile'])->middleware('auth:sanctum');
Route::post('/reset/password', [UserController::class, 'resetPassword'])->middleware('auth:sanctum');
Route::get('/profile', [DashboardController::class, 'userProfile']);