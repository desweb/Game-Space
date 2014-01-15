<?php

use App\Services\Validators\WitnessValidator;

class Api_WitnessController extends BaseController
{
	public function index($token, $reference)
	{
		$validator = WitnessValidator::api();

		if ($validator->fails())									return ApiErrorManager::errorLogs($validator->errors()->all());
		if (!$game			= Game::byReference($reference))		return ApiErrorManager::errorLogs(array('Jeu inconnu.'));
		if (!$game_witness	= GameWitness::userByGameId($game->id))	$game_witness = new GameWitness;

		$game_witness->star		= Input::get('star');
		$game_witness->message	= Input::get('message');
		$game_witness->game_id	= $game->id;
		$game_witness->user_id	= Auth::user()->id;
		$game_witness->save();

		return Response::json(array('is_success' => 1));
	}

	public function delete($token, $reference)
	{
		if (!$game			= Game::byReference($reference))		return ApiErrorManager::errorLogs(array('Jeu inconnu.'));
		if (!$game_witness	= GameWitness::userByGameId($game->id))	return ApiErrorManager::errorLogs(array('Témoignage inconnu.'));

		$game_witness->delete();

		return Response::json(array('is_success' => 1));
	}
}