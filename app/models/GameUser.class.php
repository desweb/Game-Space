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
	 * Global
	 */

	public static function rank($offset = 0, $length = 50)
	{
		$q = self::select('game_user.*')
					->join('game', 'game.id', '=', 'game_user.game_id')
					->where('game.is_main', true)
					->join('user', 'user.id', '=', 'game_user.user_id')
					->where('user.state', User::STATE_ACTIVE)
					->orderBy('score', 'desc')
					->take($length);

		if ($offset) $q->skip($offset);

		return $q->get();
	}

	public static function rankGame($game_id, $offset = 0, $length = 50)
	{
		$q = self::select('game_user.*')
					->where('game_user.game_id', $game_id)
					->join('user', 'user.id', '=', 'game_user.user_id')
					->where('user.state', User::STATE_ACTIVE)
					->orderBy('score', 'desc')
					->take($length);

		if ($offset) $q->skip($offset);

		return $q->get();
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

	public function game()
	{
		return $this->belongsTo('Game', 'game_id');
	}

	public function user()
	{
		return $this->belongsTo('User', 'user_id');
	}

	/**
	 * Getters
	 */

	public function getApiInformations()
	{
		return array(
			'reference'		=> $this->reference,
			'level'			=> $this->level,
			'score'			=> $this->score,
			'game_reference'=> $this->game->reference);
	}
}