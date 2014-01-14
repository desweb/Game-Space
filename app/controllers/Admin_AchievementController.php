<?php

use App\Services\Validators\AchievementValidator;

class Admin_AchievementController extends BaseController
{
	public function index()
	{
		return View::make('admin.achievement.index')->with('achievements', Achievement::allList());
	}

	public function add()
	{
		return View::make('admin.achievement.add');
	}

	public function addValidation()
	{
		$validator = AchievementValidator::adminAdd();

		if ($validator->fails())						return Redirect::to(URL::previous())->withErrors($validator)->withInput();
		if (Achievement::byTitle(Input::get('title')))	return Redirect::to(URL::previous())->with('message_error', 'Cet email est déjà utilisé.')->withInput();

		$achievement = new Achievement;
		$achievement->title			= Input::get('title');
		$achievement->score			= Input::get('score');
		$achievement->description	= Input::get('description');
		$achievement->setImage();
		$achievement->save();

		$users = User::users();

		foreach($users as $user)
		{
			$user_achievement = new UserAchievement;
			$user_achievement->achievement_id	= $achievement->id;
			$user_achievement->user_id			= $user->id;
			$user_achievement->save();
		}

		return Redirect::route('admin_achievement_edit', array('id' => $achievement->id))->with('message_success', 'Trophée <b>' . $achievement->title . '</b> créé.');
	}

	public function edit($id)
	{
		return View::make('admin.achievement.edit', array('achievement' => Achievement::byId($id, true)));
	}

	public function editValidation($id)
	{
		$validator = AchievementValidator::adminEdit();

		if ($validator->fails()) return Redirect::to(URL::previous())->withErrors($validator);

		$achievement = Achievement::byId($id, true);

		if (Achievement::checkTitleExist(Input::get('title'), $achievement->id)) return Redirect::to(URL::previous())->with('message_error', 'Ce titre est déjà utlisé.')->withInput();

		$achievement->title			= Input::get('title');
		$achievement->score			= Input::get('score');
		$achievement->description	= Input::get('description');
		$achievement->save();

		return Redirect::to(URL::previous())->with('message_success', 'Trophée <b>' . $achievement->title . '</b> mis à jour.');
	}

	public function imageValidation($id)
	{
		$validator = AchievementValidator::adminImage();

		if ($validator->fails()) return Redirect::to(URL::previous())->withErrors($validator);

		$achievement = Achievement::byId($id, true);
		$achievement->setImage();
		$achievement->save();

		return Redirect::to(URL::previous())->with('message_success', 'Image du trophée <b>' . $achievement->title . '</b> mise à jour.');
	}

	public function state($id, $state)
	{
		$achievement = Achievement::byId($id, true);
		$achievement->state = $state;
		$achievement->save();

		return Redirect::to(URL::previous())->with('message_success', 'Trophée <b>' . $achievement->title . '</b> ' . ($achievement->isActive()? 'activé': 'désactivé') . '.');
	}

	public function delete($id)
	{
		$achievement = Achievement::byId($id, true);

		$title = $achievement->title;

		$achievement->delete();

		return Redirect::route('admin_achievement')->with('message_success', 'Trophée <b>' . $title . '</b> supprimé.');
	}
}