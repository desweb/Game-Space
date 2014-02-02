<?php

/**
 * Global
 */

Route::get('lang/{lang}', array('as' => 'lang', 'uses' => 'LocaleController@index'));

/**
 * Backoffice
 */

Route::group(array('prefix' => 'administration'), function()
{
	// Auth
	Route::group(array('before' => 'admin_unauth'), function()
	{
		Route::get('connexion',							array('as' => 'admin_login',			'uses' => 'AdminAuthController@index'));
		Route::get('deconnexion',						array('as' => 'admin_logout',			'uses' => 'AdminAuthController@logout'));
		Route::get('recuperer-mon-mot-de-passe/{token}',array('as' => 'admin_recover_password',	'uses' => 'AdminAuthController@recoverPassword'))->where('token', '^[0-9a-f]{32}$');

		Route::post('connexion/validation',							array('as' => 'admin_login_validation',				'uses' => 'AdminAuthController@validation'));
		Route::post('mot-de-passe-perdu/validation',				array('as' => 'admin_lost_password_validation',		'uses' => 'AdminAuthController@lostPasswordValidation'));
		Route::post('recuperer-mon-mot-de-passe/{token}/validation',array('as' => 'admin_recover_password_validation',	'uses' => 'AdminAuthController@recoverPasswordValidation'))->where('token', '^[0-9a-f]{32}$');
	});

	Route::group(array('before' => 'admin_auth'), function()
	{
		// Home
		Route::get('/', array('as' => 'admin_home', 'uses' => 'AdminHomeController@index'));

		// Research
		Route::post('recherche', array('as' => 'admin_research', 'uses' => 'AdminResearchController@index'));

		// Profile
		Route::group(array('prefix' => 'profil'), function()
		{
			Route::get('/', array('as' => 'admin_profile', 'uses' => 'AdminProfileController@index'));

			Route::post('editer/validation',			array('as' => 'admin_profile_edit_validation',			'uses' => 'AdminProfileController@validation'));
			Route::post('editer/photo/validation',		array('as' => 'admin_profile_edit_photo_validation',	'uses' => 'AdminProfileController@photoValidation'));
			Route::post('editer/mot-de-pass/validation',array('as' => 'admin_profile_edit_password_validation',	'uses' => 'AdminProfileController@passwordValidation'));
		});

		// Administrator
		Route::group(array('prefix' => 'administrateur'), function()
		{
			Route::get('/',						array('as' => 'admin_administrator',		'uses' => 'AdminAdministratorController@index'));
			Route::get('ajouter',				array('as' => 'admin_administrator_add',	'uses' => 'AdminAdministratorController@add'));
			Route::get('{id}/editer',			array('as' => 'admin_administrator_edit',	'uses' => 'AdminAdministratorController@edit'))		->where('id', '^\d+$');
			Route::get('{id}/state/{state}',	array('as' => 'admin_administrator_state',	'uses' => 'AdminAdministratorController@state'))	->where('id', '^\d+$')->where('state', '^\d{1}$');
			Route::get('{id}/supprimer',		array('as' => 'admin_administrator_delete',	'uses' => 'AdminAdministratorController@delete'))	->where('id', '^\d+$');

			Route::post('ajouter/validation',		array('as' => 'admin_administrator_add_validation',	'uses' => 'AdminAdministratorController@addValidation'));
			Route::post('{id}/editer/validation',	array('as' => 'admin_administrator_edit_validation','uses' => 'AdminAdministratorController@editValidation'))->where('id', '^\d+$');
		});

		// User
		Route::group(array('prefix' => 'utilisateur'), function()
		{
			Route::get('/',					array('as' => 'admin_user',			'uses' => 'AdminUserController@index'));
			Route::get('{id}/editer',		array('as' => 'admin_user_edit',	'uses' => 'AdminUserController@edit'))		->where('id', '^\d+$');
			Route::get('{id}/state/{state}',array('as' => 'admin_user_state',	'uses' => 'AdminUserController@state'))		->where('id', '^\d+$')->where('state', '^\d{1}$');
			Route::get('{id}/mot-de-passe',	array('as' => 'admin_user_password','uses' => 'AdminUserController@password'))	->where('id', '^\d+$');
			Route::get('{id}/bannir',		array('as' => 'admin_user_ban',		'uses' => 'AdminUserController@ban'))		->where('id', '^\d+$');
			Route::get('{id}/supprimer',	array('as' => 'admin_user_delete',	'uses' => 'AdminUserController@delete'))	->where('id', '^\d+$');

			Route::post('{id}/editer/validation', array('as' => 'admin_user_edit_validation', 'uses' => 'AdminUserController@editValidation'))->where('id', '^\d+$');
		});

		// Map
		Route::group(array('prefix' => 'carte'), function()
		{
			Route::get('/',					array('as' => 'admin_map',			'uses' => 'AdminMapController@index'));
			Route::get('gestion',			array('as' => 'admin_map_add',		'uses' => 'AdminMapController@add'));
			Route::get('{id}/gestion',		array('as' => 'admin_map_edit',		'uses' => 'AdminMapController@edit'))		->where('id', '^\d+$');
			Route::get('{id}/telecharger',	array('as' => 'admin_map_download',	'uses' => 'AdminMapController@download'))	->where('id', '^\d+$');
			Route::get('{id}/supprimer',	array('as' => 'admin_map_delete',	'uses' => 'AdminMapController@delete'))		->where('id', '^\d+$');
			Route::get('gestion-principale',array('as' => 'admin_map_main',		'uses' => 'AdminMapController@main'));
		});

		// Game
		Route::group(array('prefix' => 'jeu'), function()
		{
			Route::get('/',					array('as' => 'admin_game',			'uses' => 'AdminGameController@index'));
			Route::get('ajouter',			array('as' => 'admin_game_add',		'uses' => 'AdminGameController@add'));
			Route::get('{id}/editer',		array('as' => 'admin_game_edit',	'uses' => 'AdminGameController@edit'))	->where('id', '^\d+$');
			Route::get('{id}/state/{state}',array('as' => 'admin_game_state',	'uses' => 'AdminGameController@state'))	->where('id', '^\d+$')->where('state', '^\d{1}$');
			Route::get('{id}/supprimer',	array('as' => 'admin_game_delete',	'uses' => 'AdminGameController@delete'))->where('id', '^\d+$');

			Route::post('ajouter/validation',			array('as' => 'admin_game_add_validation',			'uses' => 'AdminGameController@addValidation'));
			Route::post('{id}/editer/validation',		array('as' => 'admin_game_edit_validation',			'uses' => 'AdminGameController@editValidation'))	->where('id', '^\d+$');
			Route::post('{id}/editer/image/validation',	array('as' => 'admin_game_edit_image_validation',	'uses' => 'AdminGameController@imageValidation'))	->where('id', '^\d+$');
		});

		// Achievement
		Route::group(array('prefix' => 'trophee'), function()
		{
			Route::get('/',					array('as' => 'admin_achievement',			'uses' => 'AdminAchievementController@index'));
			Route::get('ajouter',			array('as' => 'admin_achievement_add',		'uses' => 'AdminAchievementController@add'));
			Route::get('{id}/editer',		array('as' => 'admin_achievement_edit',		'uses' => 'AdminAchievementController@edit'))	->where('id', '^\d+$');
			Route::get('{id}/state/{state}',array('as' => 'admin_achievement_state',	'uses' => 'AdminAchievementController@state'))	->where('id', '^\d+$')->where('state', '^\d{1}$');
			Route::get('{id}/supprimer',	array('as' => 'admin_achievement_delete',	'uses' => 'AdminAchievementController@delete'))	->where('id', '^\d+$');

			Route::post('ajouter/validation',			array('as' => 'admin_achievement_add_validation',		'uses' => 'AdminAchievementController@addValidation'));
			Route::post('{id}/editer/validation',		array('as' => 'admin_achievement_edit_validation',		'uses' => 'AdminAchievementController@editValidation'))	->where('id', '^\d+$');
			Route::post('{id}/editer/image/validation',	array('as' => 'admin_achievement_edit_image_validation','uses' => 'AdminAchievementController@imageValidation'))->where('id', '^\d+$');
		});

		// Witness
		Route::group(array('prefix' => 'temoignage'), function()
		{
			Route::get('/',					array('as' => 'admin_witness',			'uses' => 'AdminWitnessController@index'));
			Route::get('{id}/editer',		array('as' => 'admin_witness_edit',		'uses' => 'AdminWitnessController@edit'))	->where('id', '^\d+$');
			Route::get('{id}/state/{state}',array('as' => 'admin_witness_state',	'uses' => 'AdminWitnessController@state'))	->where('id', '^\d+$')->where('state', '^\d{1}$');
			Route::get('{id}/supprimer',	array('as' => 'admin_witness_delete',	'uses' => 'AdminWitnessController@delete'))	->where('id', '^\d+$');

			Route::post('{id}/editer/validation', array('as' => 'admin_witness_edit_validation', 'uses' => 'AdminWitnessController@editValidation'))->where('id', '^\d+$');
		});

		// Contact
		Route::group(array('prefix' => 'message'), function()
		{
			Route::get('/',				array('as' => 'admin_contact',			'uses' => 'AdminContactController@index'));
			Route::get('{id}',			array('as' => 'admin_contact_show',		'uses' => 'AdminContactController@show'))	->where('id', '^\d+$');
			Route::get('{id}/supprimer',array('as' => 'admin_contact_delete',	'uses' => 'AdminContactController@delete'))->where('id', '^\d+$');

			Route::post('{id}/repondre/validation', array('as' => 'admin_contact_answer_validation', 'uses' => 'AdminContactController@answerValidation'))->where('id', '^\d+$');
		});
	});
});

/**
 * API
 */

Route::group(array('prefix' => 'api'), function()
{
	// Home
	Route::get('/', array('as' => 'api_home', 'uses' => 'ApiHomeController@index'));

	// Contact
	Route::post('contact', array('as' => 'api_contact', 'uses' => 'ApiContactController@add'));

	// Auth
	Route::group(array('prefix' => 'auth'), function()
	{
		Route::post('/',				array('as' => 'api_auth',			'uses' => 'ApiAuthController@index'));
		Route::post('add/{hash}',		array('as' => 'api_auth_add',		'uses' => 'ApiAuthController@add'))		->where('hash', '^[0-9a-f]{32}$');
		Route::post('facebook/{hash}',	array('as' => 'api_auth_facebook',	'uses' => 'ApiAuthController@facebook'))->where('hash', '^[0-9a-f]{32}$');
		Route::post('update/{hash}',	array('as' => 'api_auth_update',	'uses' => 'ApiAuthController@update'))	->where('hash', '^[0-9a-f]{32}$');
		Route::post('password',			array('as' => 'api_auth_password',	'uses' => 'ApiAuthController@password'));

		Route::delete('{token}', array('as' => 'api_auth_delete','uses' => 'ApiAuthController@delete'))->where('token', '^[0-9a-f]{32}$');
	});

	Route::group(array('prefix' => 'me', 'before' => 'api_token'), function()
	{
		// User
		Route::post('{token}',								array('as' => 'api_user_update',			'uses' => 'ApiUserController@update'))		->where('token', '^[0-9a-f]{32}$');
		Route::post('{token}/photo',						array('as' => 'api_user_update_photo',		'uses' => 'ApiUserController@photo'))		->where('token', '^[0-9a-f]{32}$');
		Route::post('{token}/password',						array('as' => 'api_user_update_password',	'uses' => 'ApiUserController@password'))	->where('token', '^[0-9a-f]{32}$');
		Route::post('{token}/newsletter/{is_newsletter}',	array('as' => 'api_user_update_newsletter',	'uses' => 'ApiUserController@newsletter'))	->where('token', '^[0-9a-f]{32}$')->where('is_newsletter', '^1|0$');

		Route::delete('{token}', array('as' => 'api_user_delete', 'uses' => 'ApiUserController@delete'))->where('token', '^[0-9a-f]{32}$');

		// Game user
		Route::post('{token}/game/{reference}', array('as' => 'api_game_update', 'uses' => 'ApiGameUserController@update'))->where('token', '^[0-9a-f]{32}$')->where('reference', '^[0-9a-f]{32}$');

		// Game witness
		Route::post('{token}/game/{reference}/witness', array('as' => 'api_witness', 'uses' => 'ApiWitnessController@index'))->where('token', '^[0-9a-f]{32}$')->where('reference', '^[0-9a-f]{32}$');

		Route::delete('{token}/game/{reference}/witness', array('as' => 'api_witness_delete', 'uses' => 'ApiWitnessController@delete'))->where('token', '^[0-9a-f]{32}$')->where('reference', '^[0-9a-f]{32}$');

		// User achievement
		Route::post('{token}/achievement/{reference}', array('as' => 'api_achievement_update', 'uses' => 'ApiUserAchievementController@update'))->where('token', '^[0-9a-f]{32}$')->where('reference', '^[0-9a-f]{32}$');
	});

	// Rank
	Route::group(array('prefix' => 'rank'), function()
	{
		Route::get('/',									array('as' => 'api_rank',			'uses' => 'ApiRankController@index'));
		Route::get('/{offset}/{lenght}',				array('as' => 'api_rank_limit',		'uses' => 'ApiRankController@limit'))		->where('offset', '^\d+$')->where('lenght', '^\d+$');
		Route::get('game/{reference}',					array('as' => 'api_rank_game',		'uses' => 'ApiRankController@game'))		->where('reference', '^[0-9a-f]{32}$');
		Route::get('game/{reference}/{offset}/{lenght}',array('as' => 'api_rank_game_limit','uses' => 'ApiRankController@gameLimit'))	->where('reference', '^[0-9a-f]{32}$')->where('offset', '^\d+$')->where('lenght', '^\d+$');
	});

	// Map
	Route::group(array('prefix' => 'map', 'before' => 'api_auth_admin'), function()
	{
		Route::get('{id}/datas', array('as' => 'api_map_datas', 'uses' => 'ApiMapController@datas'))->where('reference', '^\d+$');

		Route::post('main',	array('as' => 'api_map_main_update','uses' => 'ApiMapController@main'));
		Route::post('/',	array('as' => 'api_map_add',		'uses' => 'ApiMapController@add'));
		Route::post('{id}',	array('as' => 'api_map_update',		'uses' => 'ApiMapController@update'))->where('reference', '^\d+$');
	});
});

/**
 * Front
 */

// Home
Route::get('/',			array('as' => 'home',	'uses' => 'HomeController@index'));
Route::get('{token}',	array('as' => 'token',	'uses' => 'HomeController@token'))->where('token', '^[0-9a-f]{32}$');

// TMP
Route::get('victor',array('as' => 'victor', 'uses' => 'HomeController@victor'));

/**
 * Composer
 */

View::composer('admin.partials.header', function($view)
{
	$view->total_witnesses_waiting	= GameWitness::waiting()->count();
	$view->total_contact_waiting	= Contact::waiting()	->count();
});

View::composer('admin.partials.menu', function($view)
{
	$view->total_witnesses_waiting	= GameWitness::waiting()->count();
	$view->total_contact_waiting	= Contact::waiting()	->count();
});