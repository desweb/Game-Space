<?php

class Api_HomeController extends BaseController
{
	public function index()
	{
		return Response::json(array(
			'description'	=> 'GameSpace API',
			'version'		=> '0.1'));
	}
}