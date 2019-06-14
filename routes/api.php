<?php

use Illuminate\Http\Request;

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

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('register-buddy', 'AuthController@registerBuddy');
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('user', 'AuthController@user');
        Route::get('get-user/{id}', 'UserController@getUser');
        Route::post('logout', 'AuthController@logout');
        Route::post('find-buddies', 'UserController@findBuddies');
        Route::post('charge-request', 'PaymentController@chargeRequest');
        Route::post('make-appointment', 'AppointmentController@makeAppointment');
        Route::get('get-appointments', 'AppointmentController@getAppointments');
        Route::post('upload-avatar', 'UserController@uploadAvatar');
        Route::post('change-info', 'UserController@changeInfo');
        Route::post('change-password', 'UserController@changePassword');
        Route::get('get-chattable-buddy', 'AppointmentController@getChattableBuddy');
        Route::get('get-buddies-to-be-judged', 'AdminController@getBuddiesToBeJudged');
        Route::post('set-status', 'AdminController@setStatus');
    });
});
