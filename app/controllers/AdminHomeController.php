<?php

class AdminHomeController extends BaseController
{
	public function index()
	{
		return View::make('admin.home')
			->with('total_witnesses_waiting',	GameWitness::waiting()	->count())
			->with('total_contact_waiting',		Contact::waiting()		->count());
	}
}