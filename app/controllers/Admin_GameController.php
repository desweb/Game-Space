<?php

use App\Services\Validators\GameValidator;

class Admin_GameController extends BaseController
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
		return View::make('admin.game.index')->with('games', Game::allList());
	}

	public function add()
	{
		return View::make('admin.game.add');
	}

	public function addValidation()
	{
		$validator = GameValidator::adminAdd();

		if ($validator->fails()) return Redirect::to(URL::previous())->withErrors($validator)->withInput();

		if (Game::byTitle(Input::get('title'))) return Redirect::to(URL::previous())->with('message_error', 'Cet email est déjà utilisé.')->withInput();

		$game = new Game;
		$game->title		= Input::get('title');
		$game->description	= Input::get('description');
		$game->setStateInactive();
		$game->setImage();
		$game->save();

		return Redirect::route('admin_game_edit', array('id' => $game->id))->with('message_success', 'Jeu <b>' . $game->title . '</b> créé.');
	}

	public function edit($id)
	{
		return View::make('admin.game.edit', array('game' => Game::byId($id, true)));
	}

	public function editValidation($id)
	{
		$validator = GameValidator::adminEdit();

		if ($validator->fails()) return Redirect::to(URL::previous())->withErrors($validator)->withInput();

		$game = Game::byId($id, true);

		if (Game::checkTitleExist(Input::get('title'), $game->id)) return Redirect::to(URL::previous())->with('message_error', 'Ce titre est déjà utlisé.')->withInput();

		$game->title		= Input::get('title');
		$game->description	= Input::get('description');
		$game->save();

		return Redirect::to(URL::previous())->with('message_success', 'Jeu <b>' . $game->title . '</b> mis à jour.');
	}

	public function imageValidation($id)
	{
		$validator = GameValidator::adminImage();

		if ($validator->fails()) return Redirect::to(URL::previous())->withErrors($validator);

		$game = Game::byId($id, true);
		$game->setImage();
		$game->save();

		return Redirect::to(URL::previous())->with('message_success', 'Image du jeu <b>' . $game->title . '</b> mis à jour.');
	}

	public function state($id, $state)
	{
		$game = Game::byId($id, true);
		$game->state = $state;
		$game->save();

		return Redirect::to(URL::previous())->with('message_success', 'Jeu <b>' . $game->title . '</b> ' . ($game->isActive()? 'activé': 'désactivé') . '.');
	}

	public function delete($id)
	{
		$game = Game::byId($id, true);

		$title = $game->title;

		$game->delete();

		return Redirect::route('admin_game')->with('message_success', 'Jeu <b>' . $title . '</b> supprimé.');
	}
}