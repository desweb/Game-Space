<?php

class UserAchievement extends Eloquent
{
	protected $table = 'user_achievement';

	/**
	 * Magic methods
	 */

	public function __construct()
	{
		$this->reference = Tools::generateUniqId();
		$this->score	= 0;
		$this->is_unlock= false;
	}

	/**
	 * Joins
	 */

	public function achievement()
	{
		return $this->belongsTo('Achievement', 'achievement_id');
	}
}