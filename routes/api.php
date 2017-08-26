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

Route::post('/register', 'Auth\RegisterController@createUser');

Route::post('/login', 'Auth\LoginController@login');

Route::post('/resend-otp', 'Auth\RegisterController@resendOTP');

Route::post('/verify-otp', 'Auth\RegisterController@verifyOTP');

Route::post('/home', 'Home\HomeController@index');

Route::post('/detail', 'Home\HomeController@detail');

Route::post('/forgot-password', 'Auth\ForgotPasswordController@index');

Route::post('/get-profile', 'Auth\ProfileController@getProfile');

Route::post('/update-profile', 'Auth\ProfileController@updateProfile');

Route::post('/game-photos', 'Game\GameController@getPhotos');