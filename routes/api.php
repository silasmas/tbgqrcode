<?php

use App\Http\Controllers\ParticipanController;
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
Route::post('login', [ParticipanController::class, "store"]);
Route::post('checkaccess/{id}', [ParticipanController::class, "verify"]);
Route::group(['middleware' => ['api', 'localization']], function () {

    // // User
    // Route::get('user/get_api_token/{email}', 'App\Http\Controllers\API\UserController@getApiToken')->name('user.get_api_token');
    // Route::post('user/login', 'App\Http\Controllers\API\UserController@login')->name('user.login');
    // Route::post('payment/store', 'App\Http\Controllers\API\PaymentController@store')->name('payment.store');
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
