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

Route::group([], function () {


    Route::get('/oauth', 'Auth\LoginController@oAuthCallback')->name('oauth');
    Route::get('/login/{type}', 'Auth\LoginController@login')->name('login');

    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::post('/user', 'Auth\LoginController@postUserData')->name('user.data');

    Route::get('', 'User\PagesController@home')->name('index');

    Route::get('pages/{page}/{subpage?}', 'User\PagesController@show')->name("pages.show");

    Route::post('reservations', 'User\ReservationController@getReservations')
        ->name('getReservations');
    Route::resource('reservation', 'User\ReservationController', ['only'=> [
        'index', 'store', 'update', 'destroy'
    ]]);

    Route::group(['prefix' => 'comment', 'middleware' => 'auth'], function () {
        Route::post('/{article}', 'User\CommentController@store')->name('comment.store');
        Route::put('/{comment}', 'User\CommentController@update')->name('comment.update');
        Route::put('/{comment}', 'User\CommentController@destroy')->name('comment.destroy');
        Route::put('/{comment}/edit', 'User\CommentController@edit')->name('comment.edit');
        Route::post('/reply/store', 'User\CommentController@replyStore')->name('comment.reply');
    });

    Route::group(['prefix' => 'contact'], function () {
        Route::get('/', 'User\ContactController@show')->name('contact.show');
        Route::post('/', 'User\ContactController@send')->name('contact.send');
    });

    Route::group(['prefix' => 'blog'], function () {
        Route::get('/', 'User\BlogController@index')->name('blog');
        Route::get('/categories', 'User\BlogController@categories')->name('blog.categories');
        Route::get('/{article}', 'User\BlogController@show')->name('blog.show');
    });

    Route::get('/lang/{code}', 'User\LanguageController')->name('language');
});
