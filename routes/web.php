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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/contacts', 'HomeController@contacts')->name('home.contacts');
Route::get('/conditions', 'HomeController@conditions')->name('home.conditions');

Route::group(['prefix' => '/profile'], function () {

    Route::get('/', 'ProfileController@index')->name('profile.index');
    Route::get('/shopping-cart', 'ProfileController@shoppingCart')->name('profile.shopping-cart');

});

Route::group(['prefix' => 'admin'], function () {

    // Orders
    Route::get('orders', 'Admin\OrderController@index')->name('admin.orders.index');

    // Users
    Route::get('users', 'Admin\UserController@index')->name('admin.users.index');

    // Categories
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', 'Admin\CategoryController@index')->name('admin.categories.index');
        Route::get('create', 'Admin\CategoryController@create')->name('admin.categories.create');
        Route::post('store', 'Admin\CategoryController@store')->name('admin.categories.store');
    });

    // Products
    Route::get('products', 'Admin\ProductController@index')->name('admin.products.index');

});
