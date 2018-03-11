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


Auth::routes();

Route::get('/', 'HomeController@index')->name('home.index');
Route::get('/contacts', 'HomeController@contacts')->name('home.contacts');
Route::get('/conditions', 'HomeController@conditions')->name('home.conditions');

Route::get('/category/{category}', 'CategoryController@show')->name('home.categories.show');
Route::get('/product/{product}', 'ProductController@show')->name('home.product.show');

Route::post('/ajax-add-to-cart/{product}', 'HomeController@ajaxAddToCart')->name('home.product.add_to_cart');
Route::post('/ajax-remove-from-cart/{product}', 'HomeController@ajaxRemoveFromCart')->name('home.product.remove_from_cart');

Route::get('/shopping-cart', 'HomeController@shoppingCart')->name('home.shopping_cart');
Route::post('/order/confirm', 'OrderController@confirm')->name('order.confirm');
Route::post('/order/address', 'OrderController@address')->name('order.address');
Route::post('/order/make', 'OrderController@make')->name('order.make');

Route::group(['prefix' => '/profile'], function () {

    Route::get('/', 'ProfileController@index')->name('profile.index');

});

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::group(['prefix' => 'admin'], function () {

    Route::redirect('/', '/dashboard', 301);

    Route::get('/dashboard', function (Request $request) {
        dd(Auth::user());
    })->name('admin.dashboard');

    // Orders
    Route::get('orders', 'Admin\OrdersController@index')->name('admin.orders.index');

    // Users
    Route::get('users', 'Admin\UsersController@index')->name('admin.users.index');

    // Categories
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', 'Admin\CategoriesController@index')->name('admin.categories.index');
        Route::get('create', 'Admin\CategoriesController@create')->name('admin.categories.create');
        Route::post('store', 'Admin\CategoriesController@store')->name('admin.categories.store');
        Route::get('edit/{category}', 'Admin\CategoriesController@edit')->name('admin.categories.edit');
        Route::put('update/{category}', 'Admin\CategoriesController@update')->name('admin.categories.update');
        Route::delete('destroy/{category}', 'Admin\CategoriesController@destroy')->name('admin.categories.destroy');
    });

    // Products
    Route::group(['prefix' => 'products'], function () {
        Route::get('/', 'Admin\ProductsController@index')->name('admin.products.index');
        Route::get('create', 'Admin\ProductsController@create')->name('admin.products.create');
        Route::post('store', 'Admin\ProductsController@store')->name('admin.products.store');
        Route::get('edit/{product}', 'Admin\ProductsController@edit')->name('admin.products.edit');
        Route::put('update/{product}', 'Admin\ProductsController@update')->name('admin.products.update');
        Route::delete('destroy/{product}', 'Admin\ProductsController@destroy')->name('admin.products.destroy');
    });

});
