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

Route::get('/', function() {
	return redirect('/webinar');
});

Route::get('home', function() {
	return redirect('/webinar');
});


Route::resource('webinar', 'WebinarController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',

]);

Route::group(['middleware' => 'auth.basic', 'prefix' => 'api'], function() {
	Route::get('/test', function() {
		return 'testing123 testing<br/>';
	});
});