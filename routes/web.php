<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InterviewFormController;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('app');
});

Route::get('/{all}', function () {
    return view('app');
})->where("all", ".*");

// Route::post('/interviewform',[InterviewFormController::class,'store']);

Route::get('/testroute', function() {
    $name = "Funny Coder";
    $mailData=[];
    Mail::to('i.tchadjobo@wequipu.com')->send(new SendMail($mailData));
});

