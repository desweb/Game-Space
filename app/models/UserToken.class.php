<?php

class UserToken extends Eloquent
{
	const LIFE_TIME_REGISTRATION_VALIDATION	= 2592000;
	const LIFE_TIME_PASSWORD_LOST			= 1800;

	const TYPE_REGISTRATION_VALIDATION	= 1;
	const TYPE_PASSWORD_LOST			= 2;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_token';

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

	public function getLifeTime()
	{
		switch ($this->type)
		{
			case self::TYPE_REGISTRATION_VALIDATION	: return self::LIFE_TIME_REGISTRATION_VALIDATION;	break;
			case self::TYPE_PASSWORD_LOST			: return self::LIFE_TIME_PASSWORD_LOST;				break;
			default: throw new Exception('You need to set type before to get token life time.');
		}
	}

	/**
	 * Setters
	 */

	public function setToken()
	{
		$this->token = md5(uniqid());
	}

	public function setExpiredAt()
	{
		$this->expired_at = date('Y-m-d H:i:s', time() + $this->getLifeTime());
	}

	public function setTypeRegistrationValidation	() { $this->type = self::TYPE_REGISTRATION_VALIDATION; }
	public function setTypePasswordLost				() { $this->type = self::TYPE_PASSWORD_LOST; }

	/**
	 * Checks
	 */

	public function isExpired()
	{
		return time() > strtotime($this->expired_at);
	}
}