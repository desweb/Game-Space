<?php

use App\Services\Validators\AuthValidator;
use App\Services\Validators\UserValidator;

class ApiAuthController extends BaseController
{
	const HASH_ADD		= 'FP2zCdnmaYGP9X2E';
	const HASH_UPDATE	= 'ATxuV3HbVn';

	public function index()
	{
		$validator = AuthValidator::connexion();

		if ($validator->fails())							return ApiErrorManager::errorLogs($validator->errors()->all());
		if (!$user = User::userByEmail(Input::get('email')))return ApiErrorManager::errorLogs(array('Identifiants de connexion incorrects.'));
		if (!$user->password == Input::get('password'))		return ApiErrorManager::errorLogs(array('Identifiants de connexion incorrects.'));
		if ($user->isInactive())							return ApiErrorManager::errorLogs(array('Compte désactivé.'));

		$user->login();

		$response = Response::json($user->getApiInformations());

		if ($cookie = $user->getAutoLogin()) $response->withCookie($cookie);

		return $response;
	}

	public function add()
	{
		$validator = UserValidator::apiAdd();

		if ($validator->fails())						return ApiErrorManager::errorLogs($validator->errors()->all());
		if (User::byEmail(Input::get('email')))			return ApiErrorManager::errorLogs(array('Cet email est déjà utilisé.'));
		if (User::byUsername(Input::get('username')))	return ApiErrorManager::errorLogs(array('Ce pseudo est déjà utilisé.'));
		if ($this->checkHashAdd())						return ApiErrorManager::errorLogs(array('Hash incorrect.'));

		$user = new User;
		$user->username		= Input::get('username');
		$user->email		= Input::get('email');
		$user->setBirthdayAt(Input::get('birthday_at'));
		$user->password		= Input::get('password');
		$user->setTypeUser();

		$user->setPhoto();
		$user->save();

		$games = Game::all();

		foreach($games as $game)
		{
			$game_user = new GameUser;
			$game_user->user_id = $user->id;
			$game_user->game_id = $game->id;
			$game_user->save();
		}

		$achievements = Achievement::all();

		foreach($achievements as $achievement)
		{
			$user_achievement = new UserAchievement;
			$user_achievement->user_id			= $user->id;
			$user_achievement->achievement_id	= $achievement->id;
			$user_achievement->save();
		}

		MailManager::userAdd($user);

		$user->login();

		$response = Response::json($user->getApiInformations());

		if ($cookie = $user->getAutoLogin()) $response->withCookie($cookie);

		return $response;
	}

	public function update()
	{
		$validator = AuthValidator::apiUpdate();

		if ($validator->fails())									return ApiErrorManager::errorLogs($validator->errors()->all());
		if ($this->checkHashUpdate())								return ApiErrorManager::errorLogs(array('Hash incorrect.'));
		if (!$user = User::userByReference(Input::get('reference')))return ApiErrorManager::errorLogs(array('Référence invalide.'));

		$user->setAuthToken();

		return Response::json($user->token->getApiInformations());
	}

	public function password()
	{
		$validator = AuthValidator::lostPassword();

		if ($validator->fails())							return ApiErrorManager::errorLogs($validator->errors()->all());
		if (!$user = User::userByEmail(Input::get('email')))return ApiErrorManager::errorLogs(array('Identifiants de connexion incorrects.'));

		$user->setPasswordLostToken();

		MailManager::lostPassword($user->token);

		return Response::json(array('is_success' => 1));
	}

	public function delete()
	{
		User::logout();

		return Response::json(array('is_success' => true));
	}

	private function checkHashAdd()
	{
		return Input::get('hash') == md5(self::HASH_ADD . Input::get('email') . Input::get('password') . Input::get('time'));
	}

	private function checkHashUpdate()
	{
		return Input::get('hash') == md5(self::HASH_UPDATE . Input::get('reference') . Input::get('time'));
	}
}