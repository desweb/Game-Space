<?php

use App\Services\Validators\ProfileValidator;

class Admin_ProfileController extends BaseController
{
	public function index()
	{
		return View::make('admin.profile.index');
	}

	public function validation()
	{
		$validator = ProfileValidator::admin();

		if ($validator->fails()) return Redirect::to(URL::previous())->withErrors($validator);

		$user_email = User::byEmail(Input::get('email'));

		if ($user_email && $user_email->id != Auth::user()->id) return Redirect::route('admin_profile')->with('message_error', 'Cet email est déjà utlisé.');

		$user_username = User::byUsername(Input::get('username'));

		if ($user_username && $user_username->id != Auth::user()->id) return Redirect::route('admin_profile')->with('message_error', 'Ce pseudo est déjà utlisé.');

		Auth::user()->username		= Input::get('username');
		Auth::user()->email			= Input::get('email');
		Auth::user()->birthday_at	= date('Y-m-d', strtotime(Input::get('birthday_at')));
		Auth::user()->save();

		return Redirect::to(URL::previous())->with('message_success', 'Vos informations générales ont été mises à jour.');
	}

	public function photoValidation()
	{
		$validator = ProfileValidator::adminPhoto();

		if ($validator->fails()) return Redirect::to(URL::previous())->withErrors($validator);

		Auth::user()->setPhoto();
		Auth::user()->save();

		return Redirect::to(URL::previous())->with('message_success', 'Votre avatar a été mis à jour.');
	}

	public function passwordValidation()
	{
		$validator = ProfileValidator::adminPassword();

		if ($validator->fails()) return Redirect::route('admin_profile')->withErrors($validator);

		if (User::cryptPassword(Input::get('old_password')) != Auth::user()->password) return Redirect::route('admin_profile')->with('message_error', 'Mot de passe incorrect.');

		Auth::user()->setPassword(Input::get('password'));
		Auth::user()->save();

		return  Redirect::to(URL::previous())->with('message_success', 'Mot de passe mis à jour.');
	}
}