<?php

class Map extends Eloquent
{
	protected $table = 'map';

	/**
	 * Specify
	 */

	public static function byId($id)
	{
		return self::where('id', $id)->first();
	}

	public static function byTitle($title)
	{
		return self::where('title', $title)->first();
	}

	/**
	 * Map
	 */

	public static function checkTitleExist($title, $id_exit)
	{
		return self::where('title', '=', $title)
					->whereNotIn('id', array($id_exit))
					->first();
	}
}