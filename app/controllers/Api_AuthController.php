<?php

class Api_AuthController extends BaseController
{
	public function index()
	{
		return Response::json(array('is_success' => true));
	}
}