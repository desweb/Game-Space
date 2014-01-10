<?php

class LocaleManager
{
	const SESSION_NAME = 'lang';

	public static $langs = array('fr', 'en');

	/**
	 * Functions
	 */

	public static function current()
	{
		if (self::session()) return;

		self::setLocale(self::$langs[0]);
	}

	private static function session()
	{
		if (!Session::has(self::SESSION_NAME) || !in_array(Session::get(self::SESSION_NAME), self::$langs)) return false;

		App::setLocale(Session::get(self::SESSION_NAME));

		return true;
	}

	/**
	 * Setters
	 */

	public static function setLocale($lang)
	{
		if (!in_array($lang, self::$langs)) return;

		App::setLocale($lang);

		Session::put(self::SESSION_NAME, App::getLocale());
	}

	/**
	 * Checks
	 */

	public static function is($lang) { return App::getLocale() == $lang; }
}