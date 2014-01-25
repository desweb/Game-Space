<?php

class AdminMapController extends BaseController
{
	const DOWNLOAD_PATH = '/homez.488/deswebcr/www/_game/game-space/public/downloads/map/';

	public function index()
	{
		return View::make('admin.map.index')->with('maps', Map::allList());
	}

	public function add()
	{
		return View::make('admin.map.manage');
	}

	public function edit($id)
	{
		return View::make('admin.map.manage')->with('map', Map::byIdOrFail($id));
	}

	public function download($id)
	{
		$map = Map::byIdOrFail($id);

		$file_path = self::DOWNLOAD_PATH . 'map-' . $map->id . '.json';

		if (file_exists($file_path)) unlink($file_path);

		file_put_contents($file_path, $map->datas);

		return Response::download($file_path);
	}

	public function delete($id)
	{
		$map = Map::byIdOrFail($id);

		$title = $map->title;

		$map->delete();

		return Redirect::route('admin_map')->with('message_success', 'Carte <b>' . $title . '</b> supprimée.');
	}

	public function main()
	{
		return View::make('admin.map.main')
					->with('game_main',	Game::main())
					->with('games',		Game::allList());
	}
}