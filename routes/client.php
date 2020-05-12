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
    Route::get('', 'Client\PagesController@home')->name('index');

    Route::get('pages/{page}/{subpage?}', 'Client\PagesController@show')->name("pages.show");

    Route::post('reservations', 'Client\ReservationController@getReservations')
        ->name('getReservations');
    Route::resource('reservation', 'Client\ReservationController', ['only'=> [
        'index', 'store', 'update', 'destroy'
    ]]);

    Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
        Route::get('/reservations', 'Client\UserReservationController@getReservations')
            ->name('user.reservations');
        Route::get('/reservations/{reservation}', 'Client\UserReservationController@getReservationICS')
            ->name('user.ics');
        Route::delete('/reservations/{reservation}', 'Client\UserReservationController@delete')
            ->name('user.reservations.delete');
    });

    Route::group(['prefix' => 'comment', 'middleware' => 'auth'], function () {
        Route::post('/{article}', 'Client\CommentController@store')->name('comment.store');
        Route::put('/{comment}', 'Client\CommentController@update')->name('comment.update');
        Route::delete('/{comment}', 'Client\CommentController@destroy')->name('comment.destroy');
        Route::put('/{comment}/edit', 'Client\CommentController@edit')->name('comment.edit');
        Route::post('/reply/store', 'Client\CommentController@replyStore')->name('comment.reply');
    });

    Route::group(['prefix' => 'contact'], function () {
        Route::get('/', 'Client\ContactController@show')->name('contact.show');
        Route::post('/', 'Client\ContactController@send')->name('contact.send');
    });

    Route::group(['prefix' => 'blog'], function () {
        Route::get('/', 'Client\BlogController@index')->name('blog');
        Route::get('/categories', 'Client\BlogController@categories')->name('blog.categories');
        Route::get('/{article}', 'Client\BlogController@show')->name('blog.show');
    });

    Route::get('/lang/{code}', 'Client\LanguageController')->name('language');
});
