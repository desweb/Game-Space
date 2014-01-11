<?php

class Tools
{
	/**
	 * Generation
	 */

	public static function generateUniqId()
	{
		return md5(uniqid(rand(), true));
	}

	public static function generatePassword($length = 8)
	{
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@-_?.:;()àéè';
		$count = mb_strlen($chars);

		for ($i = 0, $password = ''; $i < $length; $i++)
			$password .= mb_substr($chars, rand(0, $count - 1), 1);

		return $password;
	}

	public static function generateLink($link)
	{
		$replaces = array(
			array('à', 'a'),
			array('é', 'e'),
			array('è', 'e'),
			array('ê', 'e'),
			array('ë', 'e'),
			array('î', 'i'),
			array('ï', 'i'),
			array('ô', 'o'),
			array('ö', 'o'),
			array('/', '-'));

		foreach($replaces as $replace)
			$link = str_replace($replace[0], $replace[1], $link);

		return urlencode(strtolower($link));
	}
}