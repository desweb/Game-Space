<?php

class Api_MapController extends BaseController
{
	public function __construct()
	{
		$this->beforeFilter(function()
		{
			if (!Auth::check() || !Auth::user()->isAdministrator()) return ApiErrorManager::401();
		});
	}

	public function index()
	{
		return Response::json(array(
			'description'	=> 'GameSpace API',
			'version'		=> '0.1'));
	}
}