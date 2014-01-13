<?php

class Api_UserAchievementController extends BaseController
{
	public function update($token, $reference)
	{
		$validator = GameUserValidator::apiUpdate();

		if ($validator->fails())												return ApiErrorManager::errorLogs($validator->errors()->all());
		if (!$user_achievement = UserAchievement::userByReference($reference))	return ApiErrorManager::errorLogs(array('Trophée invalide.'));

		if ($user_achievement->score >= Input::get('score') || $user_achievement->is_unlock) return Response::json(array('is_success' => 1));

		$user_achievement->score = Input::get('score');

		if ($user_achievement->score >= $user_achievement->achievement->score)
		{
			$user_achievement->score = $user_achievement->achievement->score;
			$user_achievement->is_unlock = true;
		}

		$user_achievement->save();

		return Response::json(array('is_success' => 1));
	}
}