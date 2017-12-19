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

Route::group(['middleware' => ['web']], function () {
	Route::resource('admin/products', 'Admin\\ProductsController');
});

Route::group(['middleware' => ['web']], function () {
	Route::resource('admin/prices', 'Admin\\PricesController');
	Route::any('admin/prices/index/{product_id}', 'Admin\\PricesController@index')->name('prices');
});