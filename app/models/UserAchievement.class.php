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
	 * Specify
	 */

	public static function userByReference($reference)
	{
		return self::where('reference',	$reference)
					->where('user_id',	Auth::user()->id)
					->first();
	}

	/**
	 * Joins
	 */

	public function achievement()
	{
		return $this->belongsTo('Achievement', 'achievement_id');
	}

	/**
	 * Getters
	 */

	public function getApiInformations()
	{
		return array(
			'reference'				=> $this->reference,
			'score'					=> $this->score,
			'is_unlock'				=> $this->is_unlock? 1: 0,
			'achievement_reference'	=> $this->achievement->reference);
	}

	/**
	 * Getters
	 */

	public function displayUnlockLabel()
	{
		return $this->is_unlock? '&nbsp;<span class="label label-success">Débloqué</span>&nbsp;': '';
	}
}