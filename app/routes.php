<?php

// Erreur
//App::error(function(Exception $exception) { return Response::view('error.index'); });

App::missing(function($exception) { return Response::view('error.404', array(), 404); });

/**
 * Backoffice
 */

Route::group(array('prefix' => 'administration'), function()
{
	// Home
	Route::get('/', array('as' => 'admin_home', 'uses' => 'Admin_HomeController@index'));
});

/**
 * API
 */

Route::group(array('prefix' => 'api'), function()
{
	// Home
	Route::get('/', array('as' => 'admin_home', 'uses' => 'Admin_HomeController@index'));
});

/**
 * API-documentation
 */

Route::group(array('prefix' => 'api-documentation'), function()
{
	// Home
	Route::get('/', array('as' => 'admin_home', 'uses' => 'Admin_HomeController@index'));
});

/**
 * Front
 */

Route::get('/', function()
{
	return View::make('hello');
});