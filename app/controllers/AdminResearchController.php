<?php

class AdminResearchController extends BaseController
{
	public function index()
	{
		return View::make('admin.research')->with('users', User::research(Input::get('research')));
	}
}