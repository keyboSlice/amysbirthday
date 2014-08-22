<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(['before' => 'auth'], function()
{
	Route::get('/', 'HomeController@showHome');
	Route::post('/code', 'HomeController@postCode');
	Route::post('/riddle', 'HomeController@postRiddle');
});

Route::get('/login',  'HomeController@showLogin');
Route::post('/login', 'HomeController@postLogin');
