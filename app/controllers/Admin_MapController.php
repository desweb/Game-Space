<?php

use App\Services\Validators\MapValidator;

class Admin_MapController extends BaseController
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
		return View::make('admin.map.index');
	}
}