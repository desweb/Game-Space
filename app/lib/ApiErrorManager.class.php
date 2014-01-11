<?php

class ApiErrorManager
{
	private static function generateError($error) { return Response::json(array('error' => $error)); }

	public static function 401()
	{
		return self::generateError(array(
			'code'			=> 401,
			'description'	=> 'Unauthorized access'));
	}
}