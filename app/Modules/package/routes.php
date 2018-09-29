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

Route::group(['namespace' => 'App\Modules\Package\Controllers', 'middleware' => 'auth'], function() {
	Route::get('/', 'PackageController@index');
	Route::get('/package/list/{mode?}', 'PackageController@index');
	Route::post('/package/active', 'PackageController@active');
	Route::post('/package/uptodate', 'PackageController@uptodate');
	Route::get('/package/view/{id}', 'PackageController@view');
	Route::post('/package/save', 'PackageController@save');
});

Route::group(['namespace' => 'App\Modules\Package\Controllers'], function() {
	Route::get('/package/register', 'PackageController@register');
	Route::get('/package/register-success', 'PackageController@success');
	
	Route::get('/package/confirm', 'PackageController@confirm');
	Route::post('/package/deploy', 'PackageController@deploy');
	Route::post('/package/create', 'PackageController@create');
	Route::post('/package/extend', 'PackageController@extend');
	
	Route::get('/package/offline', 'PackageController@offline');
	Route::post('/package/offline/generate-code', 'PackageController@offlineGenerateCode');
	Route::any('/package/offline/activate', 'PackageController@offlineActivate');
});
