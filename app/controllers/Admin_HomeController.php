<?php

class Admin_HomeController extends BaseController
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
		return View::make('admin.home')
			->with('total_witnesses_waiting',	GameWitness::waiting()	->count())
			->with('total_contact_waiting',		Contact::waiting()		->count());
	}
}