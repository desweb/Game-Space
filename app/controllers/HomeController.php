<?php

class HomeController extends BaseController
{
	public function index()
	{
		return View::make('home')
					->with('game',			'')
					->with('games',			array())
					->with('map',			'')
					->with('achievements',	array());
	}

	public function token($token)
	{
		return View::make('hello');
	}
}