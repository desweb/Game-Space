<?php

use App\Services\Validators\MapValidator;

class Api_MapController extends BaseController
{
	public function main()
	{
		if (!Input::get('games')) return ApiErrorManager::errorLogs(array('Jeu invalide.'));

		$games = Input::get('games');

		foreach ($games as $key => $datas)
		{
			if (!$datas || $datas == '')	continue;
			if (!$game = Game::byId($key))	return ApiErrorManager::errorLogs(array('Jeu invalide.'));

			$game->datas = $datas;
			$game->save();
		}

		return Response::json(array('is_success' => 1));
	}

	public function add()
	{
		$validator = MapValidator::add();

		if ($validator->fails())				return ApiErrorManager::errorLogs($validator->errors()->all());
		if (Map::byTitle(Input::get('title')))	return ApiErrorManager::errorLogs(array('Ce titre est déjà utlisé.'));

		$map = new Map;
		$map->title			= Input::get('title');
		$map->description	= Input::get('description');
		$map->datas			= Input::get('datas');
		$map->save();

		return Response::json(array(
			'is_success'=> 1,
			'id'		=> $map->id));
	}

	public function update($id)
	{
		$validator = MapValidator::edit();

		if ($validator->fails())								return ApiErrorManager::errorLogs($validator->errors()->all());
		if (!$map = Map::byId($id))								return ApiErrorManager::errorLogs(array('Carte invalide.'));
		if (Map::checkTitleExist(Input::get('title'), $map->id))return ApiErrorManager::errorLogs(array('Ce titre est déjà utlisé.'));

		$map->title			= Input::get('title');
		$map->description	= Input::get('description');
		$map->datas			= Input::get('datas');
		$map->save();

		return Response::json(array('is_success' => 1));
	}
}