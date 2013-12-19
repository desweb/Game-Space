<?php

class Api_HomeController extends BaseController
{
	public function __construct()
	{
		$this->beforeFilter(function()
		{
		});
	}
 
	public function index()
	{
		return View::make('api.home');
	}
}