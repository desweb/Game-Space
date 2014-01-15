<?php

class HomeController extends BaseController
{
	public function index()
	{
		// TMP Hack
		if (Auth::check()) User::logout();

		return View::make('front.home')
					->with('game',			'')
					->with('games',			array())
					->with('map',			'')
					->with('achievements',	array());
	}

	public function token($token)
	{
		return View::make('front.home');
	}
}