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
Route::group(['prefix' => 'api/v1', 'namespace' => 'App\Modules\Api\Controllers', 'middleware' => 'api.auth'], function() {
	Route::get('/packages/{domain}', 'PackageController@detail');
	Route::get('/categories/{type}', 'PackageController@categories');
	Route::post('/packages/register', 'PackageController@register');
});
