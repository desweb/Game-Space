<?php

class LocaleController extends BaseController
{
	public function index($lang)
	{
		LocaleManager::setLocale($lang);

		return Redirect::to(URL::previous());
	}
}