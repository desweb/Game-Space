<?php

use App\Services\Validators\UserValidator;

class Admin_UserController extends BaseController
{
	public function __construct()
	{
		$this->beforeFilter(function()
		{
			if (!Auth::check())						return Redirect::route('admin_login');
			if (!Auth::user()->isAdministrator())	return Redirect::route('home');
		});
	}

	public function index()
	{
		return View::make('admin.user.index')->with('users', User::users());
	}

	public function edit($id)
	{
		return View::make('admin.user.edit', array('user' => User::userById($id, true)));
	}

	public function editValidation($id)
	{
		$validator = UserValidator::adminEdit();

		$user = User::userById($id, true);

		if ($validator->fails())										return Redirect::to(URL::previous())->withErrors($validator);
		if (User::checkUsernameExist(Input::get('username'), $user->id))return Redirect::to(URL::previous())->with('message_error', 'Ce pseudo est déjà utlisé.');
		if (User::checkEmailExist(Input::get('email'), $user->id))		return Redirect::to(URL::previous())->with('message_error', 'Cet email est déjà utlisé.');

		$user->username	= Input::get('username');
		$user->email	= Input::get('email');
		$user->setBirthdayAt(Input::get('birthday_at'));
		$user->save();

		return Redirect::to(URL::previous())->with('message_success', 'Utilisateur <b>' . $user->username . '</b> mis à jour.');
	}

	public function state($id, $state)
	{
		$user = User::userById($id, true);
		$user->state = $state;
		$user->save();

		return Redirect::to(URL::previous())->with('message_success', 'Utilisateur <b>' . $user->username . '</b> ' . ($user->isActive()? 'activé': 'désactivé') . '.');
	}

	public function password($id)
	{
		$user = User::userById($id, true);
		$password = Tools::generatePassword();
		$user->setPassword($password);
		$user->save();

		MailManager::userPasswordReinit($user, $password);

		return Redirect::to(URL::previous())->with('message_success', 'Utilisateur <b>' . $user->username . '</b> mot de passe réinitialisé.');;
	}

	public function ban($id)
	{
		$user = User::userById($id, true);

		if ($user->isBan()) return Redirect::route('admin_user_edit', array('id' => $user->id))->with('message_error', 'Utilisateur <b>' . $user->username . '</b> déjà banni.');

		$user->setStateBan();
		$user->save();

		MailManager::userBan($user);

		return Redirect::to(URL::previous())->with('message_success', 'Utilisateur <b>' . $user->username . '</b> banni.');
	}

	public function delete($id)
	{
		$user = User::userById($id, true);

		$username = $user->username;

		$user->delete();

		return Redirect::route('admin_user')->with('message_success', 'Utilisateur <b>' . $username . '</b> supprimé.');
	}
}