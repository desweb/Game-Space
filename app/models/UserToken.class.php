<?php

class UserToken extends Eloquent
{
	const LIFE_TIME_PASSWORD_LOST	= 1800;
	const LIFE_TIME_AUTH			= 3600;

	const TYPE_AUTH			= 1;
	const TYPE_PASSWORD_LOST= 2;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_token';

	/**
	 * Magic methods
	 */

	public function __construct()
	{
		$this->token = Tools::generateUniqId();
	}

	/**
	 * Specify
	 */

	public static function byUserIdAndType($user_id, $type)
	{
		return self::where('user_id',	$user_id)
					->where('type',		$type)
					->first();
	}

	public static function byTokenAndType($token, $type)
	{
		return self::where('token',	$token)
					->where('type',	$type)
					->first();
	}

	public static function byTokenAndValid($token)
	{
		return self::where('token',	$token)
					->where('type',	self::TYPE_AUTH)
					->where('expired_at', '>', date('Y-m-d H-i-s'))
					->first();
	}

	/**
	 * Joins
	 */

	public function user()
	{
		return $this->belongsTo('User', 'user_id');
	}

	/**
	 * Getters
	 */

	private function getLifeTime()
	{
		switch ($this->type)
		{
			case self::TYPE_PASSWORD_LOST	: return self::LIFE_TIME_PASSWORD_LOST;	break;
			case self::TYPE_AUTH			: return self::LIFE_TIME_AUTH;			break;
			default: throw new Exception('You need to set type before to get token life time.');
		}
	}

	public function getApiInformations()
	{
		return array(
			'token'		=> $this->token,
			'expired_at'=> strtotime($this->expired_at));
	}

	/**
	 * Setters
	 */

	private function setExpiredAt()
	{
		$this->expired_at = date('Y-m-d H:i:s', time() + $this->getLifeTime());
	}

	public function setTypePasswordLost()
	{
		$this->type = self::TYPE_PASSWORD_LOST;
		$this->setExpiredAt();
	}

	public function setTypeAuth()
	{
		$this->type = self::TYPE_AUTH;
		$this->setExpiredAt();
	}

	/**
	 * Checks
	 */

	public function isExpired()
	{
		return time() > strtotime($this->expired_at);
	}
}