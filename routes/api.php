<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InterviewFormController;
use App\Http\Controllers\VerificationCodesController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::apiResource('/interviewform',InterviewFormController::class);
    Route::get('/convertTocaregiver/{id}',[InterviewFormController::class,'convertTocaregiver'])->name('convertTocaregiver');
    Route::get('/countinterviewform',[InterviewFormController::class,'countinterviewform'])->name('countinterviewform');
    Route::put('/validateinterviewform/{id}',[InterviewFormController::class,'validateinterviewform'])->name('validateinterviewform');
    Route::apiResource('/verificationcode',VerificationCodesController::class);
});



Route::post('/login', [AuthController::class, 'login']);
