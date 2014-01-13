<?php

class Api_RankController extends BaseController
{
	public function index()
	{
		$this->game_users = GameUser::rank();

		return $this->convertJson();
	}

	public function limit($length, $offset)
	{
		$this->game_users = GameUser::rank($length, $offset);

		return $this->convertJson();
	}

	public function game($reference)
	{
		if (!$game = Game::byReferenceActive($reference)) return ApiErrorManager::errorLogs(array('Jeu invalide.'));

		$this->game_users = GameUser::rankGame($game->id);

		return $this->convertJson();
	}

	public function gameLimit($reference, $offset, $length)
	{
		if (!$game = Game::byReferenceActive($reference)) return ApiErrorManager::errorLogs(array('Jeu invalide.'));

		$this->game_users = GameUser::rankGame($game->id, $offset, $length);

		return $this->convertJson();
	}

	private function convertJson()
	{
		$response = array();

		foreach ($this->game_users as $key => $game_user)
		{
			$game_user_json = array();
			$game_user_json['score'] = $game_user->score;

			$user_json = array();
			$user_json['username'] = $game_user->user->username;

			$game_user_json['user']	= $user_json;
			$response[$key]			= $game_user_json;
		}

		return Response::json($response);
	}
}