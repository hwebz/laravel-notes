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

Route::get('/{author?}', [
	'uses' => 'QuoteController@getIndex',
	'as' => 'index'
]);

Route::post('/new', [
	'uses' => 'QuoteController@postQuote',
	'as' => 'new_quote'
]);

Route::get('/delete/{quote_id}', [
	'uses' => 'QuoteController@getDeleteQuote',
	'as' => 'delete_quote'
]);

Route::get('/gotemail/{author_name}', [
	'uses' => 'QuoteController@getMailCallback',
	'as' => 'mail_callback'
]);

Route::get('/admin/login', [
	'uses' => 'AdminController@getLogin',
	'as' => 'get_login'
]);

Route::post('/admin/login', [
	'uses' => 'AdminController@postLogin',
	'as' => 'post_login'
]);


Route::group(['middleware' => 'auth'], function() {
	Route::get('/admin/dashboard', [
		'uses' => 'AdminController@getDashboard',
		'as' => 'dashboard',
		// 'middleware' => 'auth'
	]);

	Route::get('/admin/logout', [
		'uses' => 'AdminController@getLogout',
		'as' => 'logout'
	]);

	Route::get('/admin/quotes', function() {
		return view('admin.quotes');
	});
	// })->middleware('auth');
});