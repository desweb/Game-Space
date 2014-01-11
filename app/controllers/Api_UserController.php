<?php

class Api_UserController extends BaseController
{
	public function index()
	{
		return Response::json(array(
			'description'	=> 'GameSpace API',
			'version'		=> '0.1'));
	}
}