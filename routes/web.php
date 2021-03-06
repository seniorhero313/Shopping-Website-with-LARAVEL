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

Route::prefix('api')->group(function (){
    Route::get('/categories','Backend\CategoryController@apiIndex');
    Route::post('/categories/attribute','Backend\CategoryController@apiIndexAttribute');
    Route::get('/cities/{provinceId}','Auth\RegisterController@getAllCities');
});
Route::group(['middleware'=>['auth']], function () {

    Route::prefix('admin')->group(function () {
        Route::get('/', 'Backend\MainController@mainPage');
        Route::resource('categories', 'Backend\CategoryController');
        Route::get('/categories/{id}/settings', 'Backend\CategoryController@indexSetting')->name('categories.indexSetting');
        Route::post('/categories/{id}/settings', 'Backend\CategoryController@saveSetting');
        Route::resource('attributes-group', 'Backend\AttributeGroupController');
        Route::resource('attributes-value', 'Backend\AttributeValueController');
        Route::resource('brands', 'Backend\BrandController');
        Route::resource('photos', 'Backend\PhotoController');
        Route::post('photos/upload', 'Backend\PhotoController@upload')->name('photos.upload');
        Route::resource('products', 'Backend\ProductController');
        Route::get('/orders', 'Backend\OrderController@index')->name('orders.index');

    });
});

Route::resource('/','Frontend\HomeController');
Route::get('lang/{locale}', 'Frontend\HomeController@lang');

Route::post('/','Frontend\UserController@register')->name('user.register');

Route::get('/add-to-cart/{id}','Frontend\CartController@addToCart')->name('cart.add');
Route::post('/remove-item/{id}','Frontend\CartController@removeItem')->name('cart.remove');
Route::get('/cart','Frontend\CartController@getCart')->name('cart.cart');


Route::group(['middleware'=>'auth'], function (){
    Route::get('/profile','Frontend\UserController@profile')->name('user.profile');
    Route::get('/order-verify','Frontend\OrderController@verify')->name('order.verify');
    Route::get('/payment-verify/{orderId}','Frontend\PaymentController@verify')->name('payment.verify');
});

Auth::routes();

