<?php

class GameUser extends Eloquent
{
	protected $table = 'game_user';

	/**
	 * Magic methods
	 */

	public function __construct()
	{
		$this->reference = Tools::generateUniqId();
		$this->level = 1;
		$this->score = 0;
	}

	/**
	 * Joins
	 */

	public function game()
	{
		return $this->belongsTo('Game', 'game_id');
	}
}