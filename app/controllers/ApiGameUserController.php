<?php

use App\Services\Validators\GameUserValidator;

class ApiGameUserController extends BaseController
{
	public function update($token, $reference)
	{
		$validator = GameUserValidator::apiUpdate();

		if ($validator->fails())								return ApiErrorManager::errorLogs($validator->errors()->all());
		if (!$game_user = GameUser::userByReference($reference))return ApiErrorManager::errorLogs(array('Jeu invalide.'));

		$game_user->score = Input::get('score');
		$game_user->level = Input::get('level');
		$game_user->save();

		return Response::json(array('is_success' => 1));
	}
}