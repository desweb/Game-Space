<?php

class Admin_ResearchController extends BaseController
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
		return View::make('admin.research')->with('users', User::research(Input::get('research')));
	}
}