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
	Route::group(array('prefix' => 'profil'), function()
	{
		Route::get('/', array('as' => 'admin_profile', 'uses' => 'Admin_ProfileController@index'));

		Route::post('editer/validation',			array('as' => 'admin_profile_edit_validation',			'uses' => 'Admin_ProfileController@validation'));
		Route::post('editer/photo/validation',		array('as' => 'admin_profile_edit_photo_validation',	'uses' => 'Admin_ProfileController@photoValidation'));
		Route::post('editer/mot-de-pass/validation',array('as' => 'admin_profile_edit_password_validation',	'uses' => 'Admin_ProfileController@passwordValidation'));
	});

	// Administrator
	Route::group(array('prefix' => 'administrateur'), function()
	{
		Route::get('/',						array('as' => 'admin_administrator',		'uses' => 'Admin_AdministratorController@index'));
		Route::get('ajouter',				array('as' => 'admin_administrator_add',	'uses' => 'Admin_AdministratorController@add'));
		Route::get('{id}/editer',			array('as' => 'admin_administrator_edit',	'uses' => 'Admin_AdministratorController@edit'))	->where('id', '^\d+$');
		Route::get('{id}/state/{state}',	array('as' => 'admin_administrator_state',	'uses' => 'Admin_AdministratorController@state'))	->where('id', '^\d+$')->where('state', '^\d{1}$');
		Route::get('{id}/supprimer',		array('as' => 'admin_administrator_delete',	'uses' => 'Admin_AdministratorController@delete'))	->where('id', '^\d+$');

		Route::post('ajouter/validation',		array('as' => 'admin_administrator_add_validation',	'uses' => 'Admin_AdministratorController@addValidation'));
		Route::post('{id}/editer/validation',	array('as' => 'admin_administrator_edit_validation','uses' => 'Admin_AdministratorController@editValidation'))->where('id', '^\d+$');
	});

	// User
	Route::group(array('prefix' => 'utilisateur'), function()
	{
		Route::get('/',					array('as' => 'admin_user',			'uses' => 'Admin_UserController@index'));
		Route::get('{id}/editer',		array('as' => 'admin_user_edit',	'uses' => 'Admin_UserController@edit'))		->where('id', '^\d+$');
		Route::get('{id}/state/{state}',array('as' => 'admin_user_state',	'uses' => 'Admin_UserController@state'))	->where('id', '^\d+$')->where('state', '^\d{1}$');
		Route::get('{id}/mot-de-passe',	array('as' => 'admin_user_password','uses' => 'Admin_UserController@password'))	->where('id', '^\d+$');
		Route::get('{id}/bannir',		array('as' => 'admin_user_ban',		'uses' => 'Admin_UserController@ban'))		->where('id', '^\d+$');
		Route::get('{id}/supprimer',	array('as' => 'admin_user_delete',	'uses' => 'Admin_UserController@delete'))	->where('id', '^\d+$');

		Route::post('{id}/editer/validation', array('as' => 'admin_user_edit_validation', 'uses' => 'Admin_UserController@editValidation'))->where('id', '^\d+$');
	});

	// Map
	Route::get('carte/gestion-carte-principale', array('as' => 'admin_manage_main', 'uses' => 'Admin_MapController@manageMain'));

	// Game
	Route::group(array('prefix' => 'jeu'), function()
	{
		Route::get('/',					array('as' => 'admin_game',			'uses' => 'Admin_GameController@index'));
		Route::get('ajouter',			array('as' => 'admin_game_add',		'uses' => 'Admin_GameController@add'));
		Route::get('{id}/editer',		array('as' => 'admin_game_edit',	'uses' => 'Admin_GameController@edit'))		->where('id', '^\d+$');
		Route::get('{id}/state/{state}',array('as' => 'admin_game_state',	'uses' => 'Admin_GameController@state'))	->where('id', '^\d+$')->where('state', '^\d{1}$');
		Route::get('{id}/supprimer',	array('as' => 'admin_game_delete',	'uses' => 'Admin_GameController@delete'))	->where('id', '^\d+$');

		Route::post('ajouter/validation',			array('as' => 'admin_game_add_validation',			'uses' => 'Admin_GameController@addValidation'));
		Route::post('{id}/editer/validation',		array('as' => 'admin_game_edit_validation',			'uses' => 'Admin_GameController@editValidation'))	->where('id', '^\d+$');
		Route::post('{id}/editer/image/validation',	array('as' => 'admin_game_edit_image_validation',	'uses' => 'Admin_GameController@imageValidation'))	->where('id', '^\d+$');
	});

	// Achievement TODO
	Route::group(array('prefix' => 'trophee'), function()
	{
		Route::get('/',					array('as' => 'admin_achievement',			'uses' => 'Admin_AchievementController@index'));
		Route::get('ajouter',			array('as' => 'admin_achievement_add',		'uses' => 'Admin_AchievementController@add'));
		Route::get('{id}/editer',		array('as' => 'admin_achievement_edit',		'uses' => 'Admin_AchievementController@edit'))	->where('id', '^\d+$');
		Route::get('{id}/state/{state}',array('as' => 'admin_achievement_state',	'uses' => 'Admin_AchievementController@state'))	->where('id', '^\d+$')->where('state', '^\d{1}$');
		Route::get('{id}/supprimer',	array('as' => 'admin_achievement_delete',	'uses' => 'Admin_AchievementController@delete'))->where('id', '^\d+$');

		Route::post('ajouter/validation',			array('as' => 'admin_achievement_add_validation',		'uses' => 'Admin_AchievementController@addValidation'));
		Route::post('{id}/editer/validation',		array('as' => 'admin_achievement_edit_validation',		'uses' => 'Admin_AchievementController@editValidation'))	->where('id', '^\d+$');
		Route::post('{id}/editer/image/validation',	array('as' => 'admin_achievement_edit_image_validation','uses' => 'Admin_AchievementController@imageValidation'))	->where('id', '^\d+$');
	});

	// Witness
	Route::group(array('prefix' => 'temoignage'), function()
	{
		Route::get('/',					array('as' => 'admin_witness',			'uses' => 'Admin_WitnessController@index'));
		Route::get('{id}/editer',		array('as' => 'admin_witness_edit',		'uses' => 'Admin_WitnessController@edit'))	->where('id', '^\d+$');
		Route::get('{id}/state/{state}',array('as' => 'admin_witness_state',	'uses' => 'Admin_WitnessController@state'))	->where('id', '^\d+$')->where('state', '^\d{1}$');
		Route::get('{id}/supprimer',	array('as' => 'admin_witness_delete',	'uses' => 'Admin_WitnessController@delete'))->where('id', '^\d+$');

		Route::post('{id}/editer/validation', array('as' => 'admin_witness_edit_validation', 'uses' => 'Admin_WitnessController@editValidation'))->where('id', '^\d+$');
	});

	// Contact
	Route::group(array('prefix' => 'message'), function()
	{
		Route::get('/',				array('as' => 'admin_contact',			'uses' => 'Admin_ContactController@index'));
		Route::get('{id}',			array('as' => 'admin_contact_show',		'uses' => 'Admin_ContactController@show'))	->where('id', '^\d+$');
		Route::get('{id}/supprimer',array('as' => 'admin_contact_delete',	'uses' => 'Admin_ContactController@delete'))->where('id', '^\d+$');

		Route::post('{id}/repondre/validation', array('as' => 'admin_contact_answer_validation', 'uses' => 'Admin_ContactController@answerValidation'))->where('id', '^\d+$');
	});
});

/**
 * API
 */

Route::group(array('prefix' => 'api'), function()
{
	// Home
	Route::get('/', array('as' => 'api_home', 'uses' => 'Api_HomeController@index'));

	// Auth
	Route::group(array('prefix' => 'auth'), function()
	{
		Route::post('/',			array('as' => 'api_auth',			'uses' => 'Api_AuthController@index'));
		Route::post('add/{hash}',	array('as' => 'api_auth_add',		'uses' => 'Api_AuthController@add'));
		Route::post('password',		array('as' => 'api_auth_password',	'uses' => 'Api_AuthController@password'));
		Route::post('update/{hash}',array('as' => 'api_auth_update',	'uses' => 'Api_AuthController@update'))->where('hash', '^[0-9a-f]{32}$');

		Route::delete('{token}', array('as' => 'api_auth_delete','uses' => 'Api_AuthController@delete'))->where('token', '^[0-9a-f]{32}$');
	});

	Route::group(array('prefix' => 'me', 'before' => 'api_token'), function()
	{
		// User
		Route::post('{token}',								array('as' => 'api_user_update',			'uses' => 'Api_UserController@update'))		->where('token', '^[0-9a-f]{32}$');
		Route::post('{token}/photo',						array('as' => 'api_user_update_photo',		'uses' => 'Api_UserController@photo'))		->where('token', '^[0-9a-f]{32}$');
		Route::post('{token}/password',						array('as' => 'api_user_update_password',	'uses' => 'Api_UserController@password'))	->where('token', '^[0-9a-f]{32}$');
		Route::post('{token}/newsletter/{is_newsletter}',	array('as' => 'api_user_update_newsletter',	'uses' => 'Api_UserController@newsletter'))	->where('token', '^[0-9a-f]{32}$')->where('is_newsletter', '^1|0$');

		Route::delete('{token}', array('as' => 'api_user_delete', 'uses' => 'Api_UserController@delete'))->where('token', '^[0-9a-f]{32}$');

		// Game user
		Route::post('{token}/game/{reference}', array('as' => 'api_game_update', 'uses' => 'Api_GameUserController@update'))->where('token', '^[0-9a-f]{32}$')->where('reference', '^[0-9a-f]{32}$');

		// User achievement
		Route::post('{token}/achievement/{reference}', array('as' => 'api_achievement_update', 'uses' => 'Api_UserAchievementController@update'))->where('token', '^[0-9a-f]{32}$')->where('reference', '^[0-9a-f]{32}$');
	});

	// Rank
	Route::group(array('prefix' => 'rank'), function()
	{
		Route::get('/',									array('as' => 'api_rank',			'uses' => 'Api_RankController@index'));
		Route::get('/{offset}/{lenght}',				array('as' => 'api_rank_limit',		'uses' => 'Api_RankController@limit'))		->where('offset', '^\d+$')->where('lenght', '^\d+$');
		Route::get('game/{reference}',					array('as' => 'api_rank_game',		'uses' => 'Api_RankController@game'))		->where('reference', '^[0-9a-f]{32}$');
		Route::get('game/{reference}/{offset}/{lenght}',array('as' => 'api_rank_game_limit','uses' => 'Api_RankController@gameLimit'))	->where('reference', '^[0-9a-f]{32}$')->where('offset', '^\d+$')->where('lenght', '^\d+$');
	});

	// Map
	Route::group(array('prefix' => 'map', 'before' => 'api_auth_admin'), function()
	{
		Route::post('/',	array('as' => 'api_map_add',		'uses' => 'Api_MapController@add'));
		Route::post('main',	array('as' => 'api_map_main_update','uses' => 'Api_MapController@main'));
		Route::post('{id}',	array('as' => 'api_map_update',		'uses' => 'Api_MapController@update'))->where('reference', '^\d+$');
	});
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