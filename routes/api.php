<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventBookingController;
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

Route::get('/test',  [TestController::class, 'index']);
Route::get('/event/timeslot',  [EventBookingController::class, 'index']);
Route::get('/event/timeslot/{id}',  [EventBookingController::class, 'index']);


Route::post('/event/schedule',  [EventBookingController::class, 'schedule']);
Route::get('/event/{id}', [EventBookingController::class, 'getSingleEvent']);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
