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
		if (!$this->checkHashAdd())						return ApiErrorManager::errorLogs(array('Hash incorrect.'));

		$user = new User;
		$user->username		= Input::get('username');
		$user->email		= Input::get('email');
		$user->setBirthdayAt(Input::get('birthday_at'));
		$user->password		= Input::get('password');
		$user->setTypeUser();

		$user->setPhoto();
		$user->save();

		$user->createGames();
		$user->createAchievements();

		MailManager::userAdd($user);

		$user->login();

		$response = Response::json($user->getApiInformations());

		if ($cookie = $user->getAutoLogin()) $response->withCookie($cookie);

		return $response;
	}

	public function facebook()
	{
		$validator = AuthValidator::facebook();

		if ($validator->fails()) return ApiErrorManager::errorLogs($validator->errors()->all());

		$facebook_datas = json_decode(Input::get('datas'));

		if (!$this->checkHashAddFacebook($facebook_datas->email)) return ApiErrorManager::errorLogs(array('Hash incorrect.'));

		if (!$user = User::byFacebookId($facebook_datas->id))
		{
			$user = User::byEmail($facebook_datas->email);

			if ($user)
			{
				$user->facebook_id = $facebook_datas->id;
				$user->save();
			}
		}

		if (!$user)
		{
			$user = new User;
			$user->username		= $facebook_datas->username;
			$user->email		= $facebook_datas->email;
			$user->setBirthdayAt($facebook_datas->birthday);
			$user->facebook_id	= $facebook_datas->id;
			$user->setTypeUser();

			$password = Tools::generatePassword();
			$user->setPassword($password);

			$user->setPhotoFacebook();
			$user->save();

			$user->createGames();
			$user->createAchievements();

			MailManager::userAddFacebook($user, $password);
		}

		$user->login();

		$response = Response::json($user->getApiInformations());

		if ($cookie = $user->getAutoLogin()) $response->withCookie($cookie);

		return $response;
	}

	public function update()
	{
		$validator = AuthValidator::apiUpdate();

		if ($validator->fails())									return ApiErrorManager::errorLogs($validator->errors()->all());
		if (!$this->checkHashUpdate())								return ApiErrorManager::errorLogs(array('Hash incorrect.'));
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

	private function checkHashAddFacebook($email)
	{
		return Input::get('hash') == md5(self::HASH_ADD . $email . Input::get('time'));
	}

	private function checkHashUpdate()
	{
		return Input::get('hash') == md5(self::HASH_UPDATE . Input::get('reference') . Input::get('time'));
	}
}