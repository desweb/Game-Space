<?php

use App\Services\Validators\ContactValidator;

class ApiContactController extends BaseController
{
	public function add()
	{
		$validator = ContactValidator::apiAdd();

		if ($validator->fails()) return ApiErrorManager::errorLogs($validator->errors()->all());

		$contact = new Contact;
		$contact->username	= Input::get('username');
		$contact->email		= Input::get('email');
		$contact->object	= Input::get('object');
		$contact->message	= Input::get('message');
		$contact->save();

		return Response::json(array('is_success' => true));
	}
}