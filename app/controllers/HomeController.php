<?php

class HomeController extends BaseController
{
	public function index()
	{
		return View::make('hello');
	}

	public function token($token)
	{
		return View::make('hello');
	}
}