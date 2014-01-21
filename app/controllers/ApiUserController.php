<?php

use App\Services\Validators\UserValidator;

class ApiUserController extends BaseController
{
	public function update()
	{
		$validator = UserValidator::apiEdit();

		if ($validator->fails())												return ApiErrorManager::errorLogs($validator->errors()->all());
		if (User::checkUsernameExist(Input::get('username'),Auth::user()->id))	return ApiErrorManager::errorLogs(array('Ce pseudo est déjà utlisé.'));
		if (User::checkEmailExist(Input::get('email'),		Auth::user()->id))	return ApiErrorManager::errorLogs(array('Cet email est déjà utlisé.'));

		Auth::user()->username	= Input::get('username');
		Auth::user()->email		= Input::get('email');
		Auth::user()->setBirthdayTime(Input::get('birthday_time'));
		Auth::user()->save();

		return Response::json(array('is_success' => 1));
	}

	public function photo()
	{
		$validator = UserValidator::apiPhoto();

		if ($validator->fails()) return ApiErrorManager::errorLogs($validator->errors()->all());

		Auth::user()->setPhoto();
		Auth::user()->save();

		return Response::json(array('is_success' => 1));
	}

	public function password()
	{
		$validator = UserValidator::apiPassword();

		if ($validator->fails()) return ApiErrorManager::errorLogs($validator->errors()->all());

		if (Input::get('old_password') != Auth::user()->password) return ApiErrorManager::errorLogs(array('Mot de passe incorrect.'));

		Auth::user()->password = Input::get('password');
		Auth::user()->save();

		return Response::json(array('is_success' => 1));
	}

	public function newsletter($token, $is_newsletter)
	{
		unset($token);

		Auth::user()->is_newsletter = $is_newsletter? true: false;
		Auth::user()->save();

		return Response::json(array('is_success' => 1));
	}

	public function delete()
	{
		User::logout();

		Auth::user()->delete();

		return Response::json(array('is_success' => 1));
	}
}