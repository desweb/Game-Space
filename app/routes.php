<?php

// Erreur
//App::error(function(Exception $exception) { return Response::view('error.index'); });

//App::missing(function($exception) { return Response::view('error.404', array(), 404); });

/**
 * Global
 */

Route::get('lang/{lang}', array('as' => 'lang', 'uses' => 'LocaleController@index'));

/**
 * Backoffice
 */

Route::group(array('prefix' => 'administration'), function()
{
	// Home
	Route::get('/', array('as' => 'admin_home', 'uses' => 'Admin_HomeController@index'));

	// Auth
	Route::get('connexion',							array('as' => 'admin_login',			'uses' => 'Admin_AuthController@index'));
	Route::get('deconnexion',						array('as' => 'admin_logout',			'uses' => 'Admin_AuthController@logout'));
	Route::get('recuperer-mon-mot-de-passe/{token}',array('as' => 'admin_recover_password',	'uses' => 'Admin_AuthController@recoverPassword'))->where('token', '^[0-9a-f]{32}$');

	Route::post('connexion/validation',							array('as' => 'admin_login_validation',				'uses' => 'Admin_AuthController@validation'));
	Route::post('mot-de-passe-perdu/validation',				array('as' => 'admin_lost_password_validation',		'uses' => 'Admin_AuthController@lostPasswordValidation'));
	Route::post('recuperer-mon-mot-de-passe/{token}/validation',array('as' => 'admin_recover_password_validation',	'uses' => 'Admin_AuthController@recoverPasswordValidation'))->where('token', '^[0-9a-f]{32}$');

	// Research
	Route::post('recherche', array('as' => 'admin_research', 'uses' => 'Admin_ResearchController@index'));

	// Profile
	Route::get('profil', array('as' => 'admin_profile', 'uses' => 'Admin_ProfileController@index'));

	Route::post('profil/editer/validation',				array('as' => 'admin_profile_edit_validation',			'uses' => 'Admin_ProfileController@validation'));
	Route::post('profil/editer/photo/validation',		array('as' => 'admin_profile_edit_photo_validation',	'uses' => 'Admin_ProfileController@photoValidation'));
	Route::post('profil/editer/mot-de-pass/validation',	array('as' => 'admin_profile_edit_password_validation',	'uses' => 'Admin_ProfileController@passwordValidation'));

	// Administrator
	Route::get('administrateur',					array('as' => 'admin_administrator',		'uses' => 'Admin_AdministratorController@index'));
	Route::get('administrateur/ajouter',			array('as' => 'admin_administrator_add',	'uses' => 'Admin_AdministratorController@add'));
	Route::get('administrateur/{id}/editer',		array('as' => 'admin_administrator_edit',	'uses' => 'Admin_AdministratorController@edit'))	->where('id', '^\d+$');
	Route::get('administrateur/{id}/state/{state}',	array('as' => 'admin_administrator_state',	'uses' => 'Admin_AdministratorController@state'))	->where('id', '^\d+$')->where('state', '^\d{1}$');
	Route::get('administrateur/{id}/supprimer',		array('as' => 'admin_administrator_delete',	'uses' => 'Admin_AdministratorController@delete'))	->where('id', '^\d+$');

	Route::post('administrateur/ajouter/validation',	array('as' => 'admin_administrator_add_validation',	'uses' => 'Admin_AdministratorController@addValidation'));
	Route::post('administrateur/{id}/editer/validation',array('as' => 'admin_administrator_edit_validation','uses' => 'Admin_AdministratorController@editValidation'))->where('id', '^\d+$');

	// User
	Route::get('utilisateur',					array('as' => 'admin_user',			'uses' => 'Admin_UserController@index'));
	Route::get('utilisateur/{id}/editer',		array('as' => 'admin_user_edit',	'uses' => 'Admin_UserController@edit'))		->where('id', '^\d+$');
	Route::get('utilisateur/{id}/state/{state}',array('as' => 'admin_user_state',	'uses' => 'Admin_UserController@state'))	->where('id', '^\d+$')->where('state', '^\d{1}$');
	Route::get('utilisateur/{id}/mot-de-passe',	array('as' => 'admin_user_password','uses' => 'Admin_UserController@password'))	->where('id', '^\d+$');
	Route::get('utilisateur/{id}/bannir',		array('as' => 'admin_user_ban',		'uses' => 'Admin_UserController@ban'))		->where('id', '^\d+$');
	Route::get('utilisateur/{id}/supprimer',	array('as' => 'admin_user_delete',	'uses' => 'Admin_UserController@delete'))	->where('id', '^\d+$');

	Route::post('utilisateur/{id}/editer/validation', array('as' => 'admin_user_edit_validation', 'uses' => 'Admin_UserController@editValidation'))->where('id', '^\d+$');

	// Map
	Route::get('carte/gestion-carte-principale', array('as' => 'admin_manage_main', 'uses' => 'Admin_MapController@manageMain'));

	// Game
	Route::get('jeu',					array('as' => 'admin_game',			'uses' => 'Admin_GameController@index'));
	Route::get('jeu/ajouter',			array('as' => 'admin_game_add',		'uses' => 'Admin_GameController@add'));
	Route::get('jeu/{id}/editer',		array('as' => 'admin_game_edit',	'uses' => 'Admin_GameController@edit'))		->where('id', '^\d+$');
	Route::get('jeu/{id}/state/{state}',array('as' => 'admin_game_state',	'uses' => 'Admin_GameController@state'))	->where('id', '^\d+$')->where('state', '^\d{1}$');
	Route::get('jeu/{id}/supprimer',	array('as' => 'admin_game_delete',	'uses' => 'Admin_GameController@delete'))	->where('id', '^\d+$');

	Route::post('jeu/ajouter/validation',			array('as' => 'admin_game_add_validation',			'uses' => 'Admin_GameController@addValidation'));
	Route::post('jeu/{id}/editer/validation',		array('as' => 'admin_game_edit_validation',			'uses' => 'Admin_GameController@editValidation'))	->where('id', '^\d+$');
	Route::post('jeu/{id}/editer/image/validation',	array('as' => 'admin_game_edit_image_validation',	'uses' => 'Admin_GameController@imageValidation'))	->where('id', '^\d+$');

	// Witness
	Route::get('temoignage',					array('as' => 'admin_witness',			'uses' => 'Admin_WitnessController@index'));
	Route::get('temoignage/{id}/editer',		array('as' => 'admin_witness_edit',		'uses' => 'Admin_WitnessController@edit'))	->where('id', '^\d+$');
	Route::get('temoignage/{id}/state/{state}',	array('as' => 'admin_witness_state',	'uses' => 'Admin_WitnessController@state'))	->where('id', '^\d+$')->where('state', '^\d{1}$');
	Route::get('temoignage/{id}/supprimer',		array('as' => 'admin_witness_delete',	'uses' => 'Admin_WitnessController@delete'))->where('id', '^\d+$');

	Route::post('temoignage/{id}/editer/validation', array('as' => 'admin_witness_edit_validation', 'uses' => 'Admin_WitnessController@editValidation'))->where('id', '^\d+$');

	// Contact
	Route::get('message',				array('as' => 'admin_contact',			'uses' => 'Admin_ContactController@index'));
	Route::get('message/{id}',			array('as' => 'admin_contact_show',		'uses' => 'Admin_ContactController@show'))	->where('id', '^\d+$');
	Route::get('message/{id}/supprimer',array('as' => 'admin_contact_delete',	'uses' => 'Admin_ContactController@delete'))->where('id', '^\d+$');

	Route::post('message/{id}/repondre/validation', array('as' => 'admin_contact_answer_validation', 'uses' => 'Admin_ContactController@answerValidation'))->where('id', '^\d+$');
});

/**
 * API
 */

Route::group(array('prefix' => 'api'), function()
{
	// Home
	Route::get('/', array('as' => 'api_home', 'uses' => 'Api_HomeController@index'));
});

/**
 * Front
 */

// Home
Route::get('/',			array('as' => 'home',	'uses' => 'HomeController@index'));
Route::get('{token}',	array('as' => 'token',	'uses' => 'HomeController@token'))->where('token', '^[0-9a-f]{32}$');

/**
 * Composer
 */

View::composer('admin.partials.header', function($view)
{
	$view->total_contact_waiting = Contact::waiting()->count();
});

View::composer('admin.partials.menu', function($view)
{
	$view->total_witnesses_waiting	= GameWitness::waiting()->count();
	$view->total_contact_waiting	= Contact::waiting()	->count();
});