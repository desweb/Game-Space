<?php

use App\Services\Validators\UserValidator;

class AdminAdministratorController extends BaseController
{
	public function index()
	{
		return View::make('admin.administrator.index')->with('administrators', User::administrators());
	}

	public function add()
	{
		return View::make('admin.administrator.add');
	}

	public function addValidation()
	{
		$validator = UserValidator::adminAdd();

		if ($validator->fails()) return Redirect::to(URL::previous())->withErrors($validator)->withInput();

		if (User::byEmail(Input::get('email')))			return Redirect::to(URL::previous())->with('message_error', 'Cet email est déjà utilisé.')	->withInput();
		if (User::byUsername(Input::get('username')))	return Redirect::to(URL::previous())->with('message_error', 'Ce pseudo est déjà utilisé.')	->withInput();

		$administrator = new User;
		$administrator->username	= Input::get('username');
		$administrator->email		= Input::get('email');
		$administrator->birthday_at	= date('Y-m-d', strtotime(Input::get('birthday_at')));
		$administrator->setTypeAdministrator();

		$password = Tools::generatePassword();
		$administrator->setPassword($password);

		$administrator->setPhoto();
		$administrator->save();

		MailManager::adminAdd($administrator, $password);

		return Redirect::route('admin_administrator_edit', array('id' => $administrator->id))->with('message_success', 'Administrateur <b>' . $administrator->username . '</b> créé.');
	}

	public function edit($id)
	{
		return View::make('admin.administrator.edit', array('administrator' => User::adminById($id, true)));
	}

	public function editValidation($id)
	{
		$validator = UserValidator::adminEdit();

		if ($validator->fails()) return Redirect::to(URL::previous())->withErrors($validator);

		$administrator = User::adminById($id, true);

		if (User::checkUsernameExist(Input::get('username'),$administrator->id)) return Redirect::to(URL::previous())->with('message_error', 'Ce pseudo est déjà utlisé.');
		if (User::checkEmailExist(Input::get('email'),		$administrator->id)) return Redirect::to(URL::previous())->with('message_error', 'Cet email est déjà utlisé.');

		$administrator->username= Input::get('username');
		$administrator->email	= Input::get('email');
		$administrator->setBirthdayAt(Input::get('birthday_at'));
		$administrator->save();

		return Redirect::to(URL::previous())->with('message_success', 'Administrateur <b>' . $administrator->username . '</b> mis à jour.');
	}

	public function state($id, $state)
	{
		$administrator = User::adminById($id, true);
		$administrator->state = $state;
		$administrator->save();

		return Redirect::to(URL::previous())->with('message_success', 'Administrateur <b>' . $administrator->username . '</b> ' . ($administrator->isActive()? 'activé': 'désactivé') . '.');
	}

	public function delete($id)
	{
		$administrator = User::adminById($id, true);

		$username = $administrator->username;

		$administrator->delete();

		return Redirect::route('admin_administrator')->with('message_success', 'Administrateur <b>' . $username . '</b> supprimé.');
	}
}