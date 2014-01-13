<?php

use App\Services\Validators\MapValidator;

class Admin_MapController extends BaseController
{
	public function index()
	{
		return View::make('admin.map.index');
	}

	public function manageMain()
	{
		return View::make('admin.map.manageMain');
	}
}