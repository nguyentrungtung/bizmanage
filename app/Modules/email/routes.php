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

Route::group(['namespace' => 'App\Modules\Email\Controllers', 'middleware' => 'auth'], function() {
	Route::get('/email', 'EmailController@index');
	Route::get('/email/create', 'EmailController@create');
	Route::get('/email/view/{id}', 'EmailController@view');
	
	Route::post('/email/save', 'EmailController@save');
	Route::post('/email/active', 'EmailController@active');
	Route::post('/email/remove', 'EmailController@remove');
	
	Route::post('/email/send', 'EmailController@send');
});
