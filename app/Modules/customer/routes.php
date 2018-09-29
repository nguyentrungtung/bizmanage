<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['namespace' => 'App\Modules\Customer\Controllers', 'middleware' => 'auth'], function() {
	Route::get('/customer', 'CustomerController@index');
	Route::get('/customer/view/{id}', 'CustomerController@view');
	
	Route::post('/customer/save', 'CustomerController@save');
	Route::post('/customer/remove', 'CustomerController@remove');
	Route::post('/customer/load-modal', 'CustomerController@loadModal');
});
