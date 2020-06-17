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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/product','ProductController@index');
Route::get('/product/detail/{id}','ProductController@detail');

Route::post('/cart/add','CartController@add');
Route::post('/cart/update','CartController@update');
Route::post('/cart/delete/{id}','CartController@delete');
Route::get('/cart/list','CartController@list');

Route::get('/address/list/{user_id}','AddressController@list');
Route::post('/address/add','AddressController@add');
Route::post('/address/update/{id}','AddressController@update');
Route::post('/address/delete/{id}','AddressController@delete');
Route::post('/address/setDefault','AddressController@setDefault');

Route::get('/order/list','OrderController@list');

Route::post('/pay/placeOrder','PayController@placeOrder');
Route::post('/pay/placeOrderFromCart','PayController@placeOrderFromCart');
Route::get('/pay/show','PayController@show');

Route::post('/comment/add','CommentController@add');