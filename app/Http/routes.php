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

Route::get('testcmd', ['middleware' => 'auth', 'uses' => 'WebinarController@cmd']);

Route::group(['middleware' => 'auth'], function() {
	Route::resource('webinar', 'WebinarController');
	Route::get('script/{webinar_id}', 'WebinarController@script');
	Route::get('actions/{webinar_id}', 'WebinarController@actions');
});
Route::get('viewers/{webinar_id}', ['middleware' => 'auth', 'uses' => 'WebinarController@viewers']);
Route::get('/action/delete/{webinar_id}/{action_id}', ['middleware' => 'auth', 'uses' => 'WebinarController@delete_action']);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',

]);
//'middleware' => 'auth.basic', 
Route::group(['prefix' => 'api'], function() {
	Route::get('/test/', function(Request $request) {
		/*    header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
		    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
		    header('Access-Control-Max-Age: 1000');
		    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');*/
		    //'response', 200, array('Access-Control-Allow-Origin' => 'http://itagtest.24techstuddev.com/', 
		return Response::json(array('success' => true, 'data' => 'here is data'))->setCallback($_GET['callback']);
	});
	Route::get('/start/{webinar_id}/{email}/{contact_id}/', 'APIController@start');
	Route::get('/end/{webinar_id}/{email}/{contact_id}/', 'APIController@end');



});

Route::group(['prefix' => 'cron'], function() {
	//Route::get('/test', );
});