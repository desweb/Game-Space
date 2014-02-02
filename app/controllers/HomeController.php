<?php

class HomeController extends BaseController
{
	public function index()
	{
		// TMP Hack
		if (Auth::check()) User::logout();

		return View::make('front.home')
					->with('game_main',	Game::main())
					->with('games',		Game::allList());
	}

	public function token($token)
	{
		$user_token = UserToken::byTokenAndType($token, UserToken::TYPE_PASSWORD_LOST);

		if ($user_token && $user_token->user->isAdministrator()) return Redirect::route('admin_home');

		if (!$user_token || $user_token->isExpired())
			return Redirect::route('home')
							->with('is_password_reinit', true)
							->with('password_reinit_error', 'Ce lien est expiré. Veuillez refaire la procédure.');

		$password = Tools::generatePassword();
		$user_token->user->setPassword($password);
		$user_token->user->save();

		$user_token->delete();
		$user_token = null;

		return Redirect::route('home')
						->with('is_password_reinit', true)
						->with('password_reinit_success', 'Votre nouveau mot de passe : <b>' . $password . '</b>');
	}

	public function victor()
	{
		return View::make('front.victor');
	}
}