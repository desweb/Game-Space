<?php

class ApiErrorManager
{
	private static function generateError($error) { return Response::json(array('error' => $error)); }

	public static function errorLogs($errors)
	{
		$errors_json = array();

		foreach ($errors as $key => $error)
			$errors_json[$key] = $error;

		return self::generateError(array(
			'code'			=> 400,
			'description'	=> 'Bad request',
			'logs'			=> $errors_json));
	}

	public static function error($error = 1)
	{
		switch($error)
		{
			case 401: $description = 'Unauthorized access'; break;
			default	: $description = 'Unknown error';
		}

		return self::generateError(array(
			'code'			=> $error,
			'description'	=> $description));
	}
}