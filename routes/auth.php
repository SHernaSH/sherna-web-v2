<?php

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

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'roles'], function () {


    Route::get('/oauth', 'Auth\LoginController@oAuthCallback')->name('oauth');
    Route::get('/login/{type}', 'Auth\LoginController@login')->name('login');
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::post('/user', 'Auth\LoginController@postUserData')->name('user.data');

});
