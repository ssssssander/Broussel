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
        Route::post('logout', 'AuthController@logout');
        Route::get('buddies', 'UserController@buddies');
        Route::post('validate-datetime', 'DateTimeController@validateDateTime');
    });
});
