<?php

/*
|------------------------------------------------------------------ --------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('auth')->group(function () {
    Route::post('/register', 'AuthController@register')->name('register');
    Route::post('/login', 'AuthController@login')->name('login');
    Route::get('/check', 'AuthController@checkAuthUser')->name('check');

    Route::middleware('auth.jwt')->group(function () {
        Route::get('logout', 'AuthController@logout')->name('logout');
    });
});

Route::middleware('auth.jwt')->group(function () {
    Route::put('user/{user}', 'UsersController@store')->name('user.update');
    Route::apiResource('user', 'UsersController', ['except' => ['update']]);

    Route::put('category/{category}', 'CategoriesController@store')->name('category.update');
    Route::get('category/user/{user}', 'CategoriesController@showByUser')->name('category.byUser');
    Route::apiResource('category', 'CategoriesController', ['except' => ['update']]);

    Route::get('product/user/{user}', 'ProductsController@showByUser')->name('product.byUser');
    Route::get('product/category/{category}', 'ProductsController@showByCategory')->name('product.byCategory');
    Route::put('product/{product}', 'ProductsController@store')->name('product.update');
    Route::apiResource('product', 'ProductsController', ['except' => ['update']]);
});


