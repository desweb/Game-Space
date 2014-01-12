<?php

use App\Services\Validators\UserValidator;

class Api_UserController extends BaseController
{
	public function __construct()
	{
		$this->beforeFilter(function()
		{
			if (!$this->user = User::userById(Config::get('api_user_id'))) return ApiErrorManager::errorLogs(array('Utilisateur inconnu.'));
		});
	}

	public function update()
	{
		$validator = UserValidator::apiEdit();

		if ($validator->fails())												return Redirect::to(URL::previous())->withErrors($validator);
		if (User::checkUsernameExist(Input::get('username'),$this->user->id))	return ApiErrorManager::errorLogs(array('Ce pseudo est déjà utlisé.'));
		if (User::checkEmailExist(Input::get('email'),		$this->user->id))	return ApiErrorManager::errorLogs(array('Cet email est déjà utlisé.'));

		$this->user->username	= Input::get('username');
		$this->user->email		= Input::get('email');
		$this->user->setBirthdayTime(Input::get('birthday_time'));
		$this->user->save();

		return Response::json(array('is_success' => 1));
	}

	public function photo()
	{
		$validator = UserValidator::apiPhoto();

		if ($validator->fails()) return Redirect::to(URL::previous())->withErrors($validator);

		$this->user->setPhoto();
		$this->user->save();

		return Response::json(array('is_success' => 1));
	}

	public function password()
	{
		$validator = UserValidator::apiPassword();

		if ($validator->fails()) return Redirect::route('admin_profile')->withErrors($validator);

		if (Input::get('old_password') != $this->user->password) return ApiErrorManager::errorLogs(array('Mot de passe incorrect.'));

		$this->user->password = Input::get('password');
		$this->user->save();

		return Response::json(array('is_success' => 1));
	}

	public function newsletter($token, $is_newsletter)
	{
		unset($token);

		$this->user->is_newsletter = $is_newsletter? true: false;
		$this->user->save();

		return Response::json(array('is_success' => 1));
	}

	public function delete()
	{
		User::logout();

		$this->user->delete();

		return Response::json(array('is_success' => 1));
	}
}