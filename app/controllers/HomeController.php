<?php

class HomeController extends BaseController
{
	public function index()
	{
		// TMP Hack
		if (Auth::check()) User::logout();

		return View::make('front.home')
					->with('game_main',	Game::main())
					->with('games',		Game::allList());
	}

	public function token($token)
	{
		return View::make('front.home');
	}

	public function victor()
	{
		return View::make('front.victor')
					->with('games', Game::allList());
	}
}