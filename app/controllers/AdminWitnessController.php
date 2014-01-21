<?php

use App\Services\Validators\WitnessValidator;

class AdminWitnessController extends BaseController
{
	public function index()
	{
		return View::make('admin.witness.index')->with('witnesses', GameWitness::allList());
	}

	public function edit($id)
	{
		return View::make('admin.witness.edit', array('witness' => GameWitness::byId($id, true)));
	}

	public function editValidation($id)
	{
		$validator = WitnessValidator::adminEdit();

		if ($validator->fails()) return Redirect::to(URL::previous())->withErrors($validator);

		$witness = GameWitness::byId($id, true);
		$witness->message = Input::get('message');
		$witness->save();

		return Redirect::to(URL::previous())->with('message_success', 'Témoignage de l\'utilisateur <b>' . $witness->user->username . '</b> mis à jour.');
	}

	public function state($id, $state)
	{
		$witness = GameWitness::byId($id, true);
		$witness->state = $state;
		$witness->save();

		return Redirect::to(URL::previous())->with('message_success', 'Témoignage de l\'utilisateur <b>' . $witness->user->username . '</b> ' . ($witness->isValidated()? 'validé': 'refusé') . '.');
	}

	public function delete($id)
	{
		$witness = GameWitness::byId($id, true);

		$username = $witness->user->username;

		MailManager::witnessDelete($witness);

		$witness->delete();

		return Redirect::route('admin_witness')->with('message_success', 'Témoignage de l\'utilisateur <b>' . $username . '</b> supprimé.');
	}
}