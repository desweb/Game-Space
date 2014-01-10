<?php

use App\Services\Validators\ContactValidator;

class Admin_ContactController extends BaseController
{
	public function __construct()
	{
		$this->beforeFilter(function()
		{
			if (!Auth::check())						return Redirect::route('admin_login');
			if (!Auth::user()->isAdministrator())	return Redirect::route('home');
		});
	}

	public function index()
	{
		return View::make('admin.contact.index')->with('contacts', Contact::allList());
	}

	public function show($id)
	{
		$contact = Contact::byId($id, true);
		$contact->setStateRead();
		$contact->save();

		return View::make('admin.contact.show', array('contact' => $contact));
	}

	public function answerValidation($id)
	{
		$validator = ContactValidator::adminAnswer();

		if ($validator->fails()) return Redirect::to(URL::previous())->withErrors($validator);

		$contact = Contact::byId($id, true);
		$contact->setStateAnswered();
		$contact->save();

		MailManager::contactAnswer($contact, Input::get('answer'));

		return Redirect::to(URL::previous())->with('message_success', 'Réponse envoyée au message de <b>' . $contact->username . '</b>.');
	}

	public function delete($id)
	{
		$contact = Contact::byId($id, true);

		$username = $contact->username;

		$contact->delete();

		return Redirect::route('admin_contact')->with('message_success', 'Message de <b>' . $username . '</b> supprimé.');
	}
}