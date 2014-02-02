<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function()
{
	LocaleManager::current();

	Config::set('title', 'GameSpace');

	Config::set('url_sensiolab_insight_medal',	'https://insight.sensiolabs.com/projects/b53d9e87-a580-4503-bf10-9fc2e0d2de5f/big.png');
	Config::set('url_sensiolab_project',		'https://insight.sensiolabs.com/account/widget?project=b53d9e87-a580-4503-bf10-9fc2e0d2de5f');

	Config::set('url_analytics', 'https://www.google.com/analytics/web/?hl=fr&pli=1#report/visitors-overview/a46865258w77998084p80641792/');

	Config::set('email_signature', '<p>L\'équipe GameSpace</p>');

	Config::set('facebook_app_id',		'1407465939501094');
	Config::set('facebook_channel_url',	'http://game-space.desweb-creation.fr/');
});

/**
 * Admin
 */

Route::filter('admin_unauth', function()
{
	if (Route::currentRouteName() == 'admin_registration_token_validation')	User::logout();
	if (Auth::check()	&& !Auth::user()->isAdministrator())				return Redirect::route('home');
	if ((Auth::check()	&& Route::currentRouteName() != 'admin_logout'))	return Redirect::route('admin_home');
});

Route::filter('admin_auth', function()
{
	if (!Auth::check())						return Redirect::route('admin_login');
	if (!Auth::user()->isAdministrator())	return Redirect::route('home');
});

/**
 * API
 */

Route::filter('api_token', function($route)
{
	if (!$user_token = UserToken::byTokenAndValid($route->getParameter('token'))) return ApiErrorManager::errorLogs(array('Token invalide.'));

	Auth::login($user_token->user);
});

Route::filter('api_auth_admin', function()
{
	if (!Auth::check())						return ApiErrorManager::error(401);
	if (!Auth::user()->isAdministrator())	return ApiErrorManager::error(401);
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});