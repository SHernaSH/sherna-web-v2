<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth' ,'roles']],function () {

    Route::group(['prefix' => 'summernote'], function () {
        Route::get('/getImage/{name}', 'Admin\ImageController@getImage')->name('image.get');
        Route::post('/saveImage', 'Admin\ImageController@saveImage')->name('image.save');
    });

    Route::group(['prefix' => 'documents'], function () {
        Route::get('/', 'Admin\DocumentController@index')->name('document.index');
        Route::post('/upload', 'Admin\DocumentController@upload')->name('document.upload');;
        Route::get('/{path}', 'Admin\DocumentController@delete')->name('document.delete');;
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', 'Admin\AdminController')->name('admin.index');

        Route::group(['prefix' => 'page'], function () {
            Route::get('/standalone', 'Admin\PageController@standalone')
                ->name('page.standalone');

            Route::get('/navigation', 'Admin\PageController@navigation')
                ->name('page.navigation');

            Route::get('/subnavigation', 'Admin\PageController@subnavigation')
                ->name('page.subnavigation');

            Route::delete('/{page}/{type}', 'Admin\PageController@destroy')
                ->name('page.destroy');

            Route::get('/{page}/{type}', 'Admin\PageController@edit')
                ->name('page.edit');

            Route::put('/{page}/{type}', 'Admin\PageController@update')
                ->name('page.update');

            Route::get('/{page}/{type}/public', 'Admin\PageController@public')
                ->name('page.public');

        });

        Route::group(['prefix' => 'users'], function () {
            Route::get('/auto', 'Admin\UserController@auto')
                ->name('user.auto');

            Route::get('/index', 'Admin\UserController@index')
                ->name('user.index');

            Route::post('/filter', 'Admin\UserController@indexFilter')
                ->name('user.filter');

            Route::get('/{user}/ban', 'Admin\UserController@ban')
                ->name('user.ban');

            Route::put('/{user}/role', 'Admin\UserController@updateRole')
                ->name('user.role');

        });

        Route::resource('/game', 'Admin\GameController', [
            'except' => [ 'show' ]
        ]);
        Route::resource('/console', 'Admin\ConsoleController', [
            'except' => [ 'show' ]
        ]);
        Route::resource('/console/type', 'Admin\ConsoleTypeController', ['only' => [
            'create', 'store', 'edit', 'update', 'destroy'
        ]]);
        Route::resource('/inventory', 'Admin\InventoryController', [
            'except' => [ 'show' ]
        ]);
        Route::resource('/inventory/category', 'Admin\InventoryCategoryController', [
            'as' => 'inventory', 'except' => [ 'show' ]
        ]);

        Route::get('/article/auto', 'Admin\ArticleCategoryController@auto')
            ->name('article.auto');
        Route::resource('/category', 'Admin\ArticleCategoryController', [
            'except' => [ 'show' ]
        ]);

        Route::get('/article/{article}/public', 'Admin\ArticleController@public')
            ->name('article.public');
        Route::get('/article/create/{category}', 'Admin\ArticleController@createWithCategory')
            ->name('article.category');
        Route::resource('/article', 'Admin\ArticleController', [
            'except' => [ 'show' ]
        ]);
        Route::resource('/role', 'Admin\RoleController', [
            'except' => [ 'show' ]
        ]);

        Route::get('/permission/generate','Admin\PermissionController@generate')->name('permission.generate');
        Route::resource('/permission', 'Admin\PermissionController',['only' => [
            'index', 'edit', 'update', 'destroy'
        ]]);
        Route::resource('/location', 'Admin\LocationController', [
            'except' => [ 'show' ]
        ]);
        Route::resource('/location/status', 'Admin\LocationStatusController', [
            'except' => [ 'show', 'index' ]
        ]);


        Route::group(['prefix' => 'navigation'], function () {
            Route::get('/{navigation}/public', 'Admin\NavigationController@public')
                ->name('navigation.public');
            Route::post('/reorder', 'Admin\NavigationController@reorder')
                ->name('navigation.reorder');
        });
        Route::resource('/navigation', 'Admin\NavigationController', [
            'except' => [ 'show' ]
        ]);

        Route::group(['prefix' => 'subnavigation'], function () {
            Route::get('/{subnavigation}/public', 'Admin\SubpageController@public')
                ->name('subnavigation.public');
            Route::post('/reorder', 'Admin\SubpageController@reorder')
                ->name('subnavigation.reorder');
        });
        Route::resource('/subnavigation', 'Admin\SubpageController', ['only' => [
             'store', 'create', 'edit', 'update', 'destroy',
        ]]);

        Route::group(['prefix' => 'settings'], function () {
            Route::get('/', 'Admin\SettingController@index')->name('settings.index');
            Route::put('/', 'Admin\SettingController@update')->name('settings.update');
        });

        Route::resource('/reservation', 'Admin\ReservationController', [
            'as' => 'admin', 'except' => [ 'show' ]
        ]);

    });



});
