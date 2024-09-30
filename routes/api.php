<?php

use App\Http\Controllers\API\NotificationsController;
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


Route::post('/register',[\App\Http\Controllers\API\RegisterController::class,'register']);
Route::post('/login',[\App\Http\Controllers\API\RegisterController::class,'login']);

Route::post('/password-reset-while-disconnected',[\App\Http\Controllers\API\RegisterController::class,'password_reset_init_while_disconnected']);



Route::post('/tab/list',[\App\Http\Controllers\API\TabController::class,'list']);
Route::post('/tab/campus-set',[\App\Http\Controllers\API\TabController::class,'set_campus']);


Route::middleware('auth:sanctum')->group(function (){

    Route::post('/booking-params',[\App\Http\Controllers\API\BookingController::class,'params']);
    Route::post('/booking-process',[\App\Http\Controllers\API\BookingController::class,'exec']);


    Route::post('/histo',[\App\Http\Controllers\API\BookingController::class,'histo']);
    Route::post('/data',[\App\Http\Controllers\API\RegisterController::class,'data']);


    Route::post('/password-reset',[\App\Http\Controllers\API\RegisterController::class,'password_reset_init']);
    Route::post('/email-reset-init',[\App\Http\Controllers\API\RegisterController::class,'email_reset_init']);
    Route::post('/email-reset',[\App\Http\Controllers\API\RegisterController::class,'otp_validate']);


    Route::get('/notifications', [NotificationsController::class, 'index']);
    Route::get('/notifications/unread', [NotificationsController::class, 'unread']);
    Route::post('/notifications/{id}/read', [NotificationsController::class, 'markAsRead']);

});


