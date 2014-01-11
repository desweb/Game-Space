<?php

use App\Services\Validators\AuthValidator;

class Admin_AuthController extends BaseController
{
	public function __construct()
	{
		$this->beforeFilter(function()
		{
			if (Route::currentRouteName() == 'admin_registration_token_validation') User::logout();

			if (Auth::check() && !Auth::user()->isAdministrator()) return Redirect::route('home');

			if ((Auth::check() && Route::currentRouteName() != 'admin_logout')) return Redirect::route('admin_home');
		});
	}

	public function index()
	{
		return View::make('admin.auth.index');
	}

	public function validation()
	{
		$validator = AuthValidator::connexion();

		if ($validator->fails()) return Redirect::route('admin_login')->withErrors($validator);

		if (!$user = User::adminByEmail(Input::get('email'))) return Redirect::route('admin_login')->with('message_error', 'Identifiants de connexion incorrects.');

		if (!$user->checkPassword(Input::get('password'))) return Redirect::route('admin_login')->with('message_error', 'Identifiants de connexion incorrects.');

		$user->login();
		$cookie = $user->getAutoLogin();

		return $cookie? Redirect::route('admin_home')->withCookie($cookie): Redirect::route('admin_home');
	}

	public function logout()
	{
		User::logout();

		return Redirect::route('admin_login');
	}

	public function lostPasswordValidation()
	{
		$validator = AuthValidator::lostPassword();

		if ($validator->fails()) return Redirect::to(URL::previous())->withErrors($validator);

		if (!$user = User::adminByEmail(Input::get('email'))) return Redirect::to(URL::previous())->with('message_error', 'Administrateur non trouvé.');

		if ($user_token = UserToken::byUserIdAndType($user->id, UserToken::TYPE_PASSWORD_LOST))
		{
			$user_token->delete();
			$user_token = null;
		}

		$user_token = new UserToken;
		$user_token->user_id = $user->id;
		$user_token->setTypePasswordLost();
		$user_token->save();

		MailManager::adminLostPassword($user_token);

		return Redirect::route('admin_login')->with('message_success', 'Un email vient de vous être envoyé pour vous permettre de réinitialiser votre mot de passe.');
	}

	public function recoverPassword($token)
	{
		$user_token = UserToken::byTokenAndType($token, UserToken::TYPE_PASSWORD_LOST);

		if ($user_token && !$user_token->user->isAdministrator()) return Redirect::route('token', array('token' => $user_token->token));

		if (!$user_token || $user_token->isExpired()) return Redirect::route('admin_login')->with('message_error', 'Ce lien est expiré. Veuillez refaire la procédure.');

		return View::make('admin.auth.recoverPassword')->with('user_token', $user_token);
	}

	public function recoverPasswordValidation($token)
	{
		$validator = AuthValidator::recoverPassword();

		if ($validator->fails()) return Redirect::to(URL::previous())->withErrors($validator);

		$user_token = UserToken::byTokenAndType($token, UserToken::TYPE_PASSWORD_LOST);

		if ($user_token && !$user_token->user->isAdministrator()) return Redirect::route('token', array('token' => $user_token->token));

		if (!$user_token || $user_token->isExpired()) return Redirect::route('admin_login')->with('message_error', 'Ce lien est expiré. Veuillez refaire la procédure.');

		$user_token->user->setPassword(Input::get('password'));
		$user_token->user->save();

		$user_token->delete();
		$user_token = null;

		return Redirect::route('admin_login')->with('message_success', 'Votre mot de passe a été réinitialisé.');
	}
}