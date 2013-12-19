<?php

class Admin_HomeController extends BaseController
{
	public function __construct()
	{
		$this->beforeFilter(function()
		{
		});
	}
 
	public function index()
	{
		return View::make('admin.home');
	}
}