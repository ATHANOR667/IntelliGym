<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/otp-request',[\App\Http\Controllers\API\RegisterController::class,'otp_request']);
Route::post('/otp-validate',[\App\Http\Controllers\API\RegisterController::class,'otp_validate']);


Route::post('/register',[\App\Http\Controllers\api\RegisterController::class,'register']);
Route::post('/login',[\App\Http\Controllers\api\RegisterController::class,'login']);


Route::middleware('auth:sanctum')->group(function (){
    Route::post('/booking_params',[\App\Http\Controllers\API\BookingController::class,'params']);
    Route::post('/booking_process',[\App\Http\Controllers\API\BookingController::class,'exec']);
    Route::post('/histo',[\App\Http\Controllers\API\BookingController::class,'histo']);


});


