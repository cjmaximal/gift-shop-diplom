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

Route::get('/order-mail', function () {
    $order = App\Order::firstOrFail();

    return new App\Mail\OrderCreated($order);
});

Route::get('/', 'HomeController@index')->name('home.index');
Route::get('/contacts', 'HomeController@contacts')->name('home.contacts');
Route::get('/conditions', 'HomeController@conditions')->name('home.conditions');

Route::get('/category/{category}', 'CategoryController@show')->name('home.categories.show');
Route::get('/product/{product}', 'ProductController@show')->name('home.product.show');

Route::post('/ajax-add-to-cart/{product}', 'HomeController@ajaxAddToCart')->name('home.product.add_to_cart');
Route::post('/ajax-remove-from-cart/{product}', 'HomeController@ajaxRemoveFromCart')->name('home.product.remove_from_cart');

Route::get('/shopping-cart', 'HomeController@shoppingCart')->name('home.shopping_cart');
Route::get('/order/confirm', 'OrderController@confirm')->name('order.confirm');
Route::get('/order/address', 'OrderController@address')->name('order.address');
Route::post('/order/make', 'OrderController@make')->name('order.make');
Route::get('/order/{id}/details/', 'OrderController@show')->name('order.show');

Route::group(['prefix' => '/profile'], function () {

    Route::get('/', 'ProfileController@index')->name('profile.index');
    Route::get('/personal', 'ProfileController@editPersonal')->name('profile.personal.edit');
    Route::put('/personal', 'ProfileController@updatePersonal')->name('profile.personal.update');
    Route::get('/address', 'ProfileController@editAddress')->name('profile.address.edit');
    Route::put('/address', 'ProfileController@updateAddress')->name('profile.address.update');

});

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::group(['prefix' => 'admin'], function () {

    Route::redirect('/', '/dashboard', 301);

    Route::get('/dashboard', function (Request $request) {
        dd(Auth::user());
    })->name('admin.dashboard');

    // Orders
    Route::group(['prefix' => 'orders'], function () {


        Route::get('/', 'Admin\OrdersController@index')->name('admin.orders.index');
        Route::get('/{id}/edit', 'Admin\OrdersController@edit')->name('admin.orders.edit');
        Route::put('/{id}', 'Admin\OrdersController@update')->name('admin.orders.update');
        Route::delete('/{id}', 'Admin\OrdersController@destroy')->name('admin.orders.destroy');

    });

    // Users
    Route::get('users', 'Admin\UsersController@index')->name('admin.users.index');

    // Categories
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', 'Admin\CategoriesController@index')->name('admin.categories.index');
        Route::get('/create', 'Admin\CategoriesController@create')->name('admin.categories.create');
        Route::post('/store', 'Admin\CategoriesController@store')->name('admin.categories.store');
        Route::get('/{category}/edit', 'Admin\CategoriesController@edit')->name('admin.categories.edit');
        Route::put('/{category}', 'Admin\CategoriesController@update')->name('admin.categories.update');
        Route::delete('/{category}', 'Admin\CategoriesController@destroy')->name('admin.categories.destroy');
    });

    // Products
    Route::group(['prefix' => 'products'], function () {
        Route::get('/', 'Admin\ProductsController@index')->name('admin.products.index');
        Route::get('/create', 'Admin\ProductsController@create')->name('admin.products.create');
        Route::post('/store', 'Admin\ProductsController@store')->name('admin.products.store');
        Route::get('/{product}/edit', 'Admin\ProductsController@edit')->name('admin.products.edit');
        Route::put('/{product}', 'Admin\ProductsController@update')->name('admin.products.update');
        Route::delete('/{product}', 'Admin\ProductsController@destroy')->name('admin.products.destroy');
    });

});
