<?php

class AdminResearchController extends BaseController
{
	public function index()
	{
		return View::make('admin.research')
			->with('users',			User::research(Input::get('research')))
			->with('administrators',User::adminResearch(Input::get('research')))
			->with('maps',			Map::research(Input::get('research')))
			->with('games',			Game::research(Input::get('research')))
			->with('achievements',	Achievement::research(Input::get('research')))
			->with('witnesses',		GameWitness::research(Input::get('research')))
			->with('contacts',		Contact::research(Input::get('research')));
	}
}