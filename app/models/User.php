<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface
{
	const SECURITY_HASH = '9mrfSL6GfFqC79KI';

	const COOKIE_LIFE_TIME = 2592000;

	const TYPE_ADMINISTRATOR= 1;
	const TYPE_USER			= 2;

	const STATE_ACTIVE	= 1;
	const STATE_INACTIVE= 2;
	const STATE_BAN		= 3;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	/**
	 * Magic methods
	 */

	public function __construct()
	{
		$this->reference = Tools::generateUniqId();
		$this->setStateActive();
	}

	/**
	 * Global
	 */

	public static function users()
	{
		return self::where('type', self::TYPE_USER)
					->orderBy('created_at', 'desc')
					->get();
	}

	public static function administrators()
	{
		return self::where('type', self::TYPE_ADMINISTRATOR)
					->orderBy('created_at', 'desc')
					->get();
	}

	public static function research($research)
	{
		$users = self::where('type', self::TYPE_USER)
					->where(function($q) use ($research)
					{
						$q->where('reference',		'like', '%' . $research . '%')
							->orWhere('username',	'like', '%' . $research . '%')
							->orWhere('email',		'like', '%' . $research . '%');
					})
					->get();

		foreach ($users as $user)
		{
			$user->reference= Tools::stringBold($research, $user->reference);
			$user->username	= Tools::stringBold($research, $user->username);
			$user->email	= Tools::stringBold($research, $user->email);
		}

		return $users;
	}

	public static function adminResearch($research)
	{
		$users = self::where('type', self::TYPE_ADMINISTRATOR)
					->where(function($q) use ($research)
					{
						$q->where('reference',		'like', '%' . $research . '%')
							->orWhere('username',	'like', '%' . $research . '%')
							->orWhere('email',		'like', '%' . $research . '%');
					})
					->get();

		foreach ($users as $user)
		{
			$user->reference= Tools::stringBold($research, $user->reference);
			$user->username	= Tools::stringBold($research, $user->username);
			$user->email	= Tools::stringBold($research, $user->email);
		}

		return $users;
	}

	/**
	 * Specify
	 */

	public static function byUsername($username)
	{
		return self::where('username', $username)->first();
	}

	public static function byEmail($email)
	{
		return self::where('email', $email)->first();
	}

	public static function byFacebookId($facebook_id)
	{
		return self::where('facebook_id', $facebook_id)->first();
	}

	public static function userById($id, $is_fail = false)
	{
		$q = self::where('type',	self::TYPE_USER)
					->where('id',	$id);

		return $is_fail? $q->firstOrFail(): $q->first();
	}

	public static function userByReference($reference, $is_fail = false)
	{
		$q = self::where('type',		self::TYPE_USER)
					->where('reference',$reference);

		return $is_fail? $q->firstOrFail(): $q->first();
	}

	public static function userByEmail($email, $is_fail = false)
	{
		$q = self::where('type',	self::TYPE_USER)
					->where('email',$email);

		return $is_fail? $q->firstOrFail(): $q->first();
	}

	public static function adminById($id, $is_fail = false)
	{
		$q = self::where('type',	self::TYPE_ADMINISTRATOR)
					->where('id',	$id);

		return $is_fail? $q->firstOrFail(): $q->first();
	}

	public static function adminByUsername($username, $is_fail = false)
	{
		$q = self::where('type',		self::TYPE_ADMINISTRATOR)
					->where('username',	$username);

		return $is_fail? $q->firstOrFail(): $q->first();
	}

	public static function adminByEmail($email, $is_fail = false)
	{
		$q = self::where('email',	$email)
					->where('type',	self::TYPE_ADMINISTRATOR);

		return $is_fail? $q->firstOrFail(): $q->first();
	}

	/**
	 * Joins
	 */

	public function token()
	{
		return $this->hasOne('UserToken', 'user_id');
	}

	public function photo()
	{
		return $this->belongsTo('Image', 'photo_id');
	}

	public function achievements()
	{
		return $this->hasMany('UserAchievement', 'user_id');
	}

	public function games()
	{
		return $this->hasMany('GameUser', 'user_id');
	}

	public function witnesses()
	{
		return $this->hasMany('GameWitness', 'user_id');
	}

	/**
	 * Functionalities
	 */

	public function login()
	{
		Auth::login($this);

		Session::put('user',	$this);
		Session::put('user_id',	$this->id);

		$this->setAuthToken();
	}

	public static function autoLogin()
	{
		if (!Cookie::has('remember')) return false;

		$user = self::adminByEmail(Cookie::get('remember')['email']);

		if (!$user || Cookie::get('remember')['password'] != $user->password) return false;

		$user->login();

		return true;
	}

	public static function logout()
	{
		if (Auth::user()->token) Auth::user()->token->delete();

		Auth::logout();

		Session::flush();

		if (!Cookie::has('remember')) Cookie::forget('remember');
	}

	public static function cryptPassword($password)
	{
		return md5(self::SECURITY_HASH . $password);
	}

	public function createGames()
	{
		$games = Game::all();

		foreach($games as $game)
		{
			$game_user = new GameUser;
			$game_user->user_id = $this->id;
			$game_user->game_id = $game->id;
			$game_user->save();
		}
	}

	public function createAchievements()
	{
		$achievements = Achievement::all();

		foreach($achievements as $achievement)
		{
			$user_achievement = new UserAchievement;
			$user_achievement->user_id			= $this->id;
			$user_achievement->achievement_id	= $achievement->id;
			$user_achievement->save();
		}
	}

	/**
	 * Overrides
	 */

	public function delete()
	{
		$photo			= $this->photo;
		$token			= $this->token;
		$achievements	= $this->achievements;
		$games			= $this->games;
		$witnesses		= $this->witnesses;

		if ($token) $token->delete();

		foreach ($achievements	as $achievement)$achievement->delete();
		foreach ($games			as $game)		$game		->delete();
		foreach ($witnesses		as $witness)	$witness	->delete();

		parent::delete();

		$photo->delete();
	}

	/**
	 * Getters
	 */

	public function getAutoLogin()
	{
		return Cookie::make('remember', array('email' => $this->email, 'password' => $this->password), time() + self::COOKIE_LIFE_TIME);
	}

	public function getPhotoUrl()
	{
		return $this->photo->url? $this->photo->url: '';
	}

	public function getApiInformations()
	{
		$user_token = UserToken::byUserIdAndType($this->id, UserToken::TYPE_AUTH);

		$response = array(
			'user_token' 	=> $user_token->getApiInformations(),
			'reference'		=> $this->reference,
			'username'		=> $this->username,
			'email'			=> $this->email,
			'birthday_time'	=> strtotime($this->birthday_at) * 1000,
			'is_newsletter'	=> $this->is_newsletter? 1: 0,
			'facebook_id'	=> $this->facebook_id? $this->facebook_id: 0,
			'photo_url'		=> $this->photo->url);

		$achievements_json	= array();
		$games_json			= array();
		$witnesses_json		= array();

		foreach ($this->achievements	as $key => $achievement)$achievements_json	[$key] = $achievement	->getApiInformations();
		foreach ($this->games			as $key => $game)		$games_json			[$key] = $game			->getApiInformations();
		foreach ($this->witnesses		as $key => $witness)	$witnesses_json		[$key] = $witness		->getApiInformations();

		$response['achievements']	= $achievements_json;
		$response['games']			= $games_json;
		$response['witnesses']		= $witnesses_json;

		return $response;
	}

	/**
	 * Setters
	 */

	public function setPassword	($password)	{ $this->password = self::cryptPassword($password); }

	public function setBirthdayAt	($birthday_at)	{ $this->birthday_at = date('Y-m-d', strtotime($birthday_at)); }
	public function setBirthdayTime	($birthday_time){ $this->birthday_at = date('Y-m-d', (int) $birthday_time); }

	public function setPhoto()
	{
		if (!Input::hasFile('photo')) return;

		if ($this->photo_id) $image = $this->photo;
		else
		{
			$image = new Image;
			$image->setTypeProfile();
		}

		$image->setOwner($this);
		$image->upload('photo', false);
	}

	public function setPhotoFacebook()
	{
		$image = new Image;
		$image->setTypeProfile();
		$image->setFacebookOwner($this);
	}

	public function setTypeAdministrator() { $this->type = self::TYPE_ADMINISTRATOR; }
	public function setTypeUser			() { $this->type = self::TYPE_USER; }

	public function setStateActive		() { $this->state = self::STATE_ACTIVE; }
	public function setStateInactive	() { $this->state = self::STATE_INACTIVE; }
	public function setStateBan			() { $this->state = self::STATE_BAN; }
	public function setStateValidation	() { $this->state = self::STATE_VALIDATION; }

	public function setAuthToken()
	{
		if ($this->token) $this->token->delete();

		$token = new UserToken;
		$token->user_id = $this->id;
		$token->setTypeAuth();
		$token->save();

		$this->token = $token;
	}

	public function setPasswordLostToken()
	{
		if ($this->token) $this->token->delete();

		$token = new UserToken;
		$token->user_id = $this->id;
		$token->setTypePasswordLost();
		$token->save();

		$this->token = $token;
	}

	/**
	 * Check
	 */

	public function isAdministrator	() { return $this->type == self::TYPE_ADMINISTRATOR; }
	public function isUser			() { return $this->type == self::TYPE_USER; }

	public function isActive	() { return $this->state == self::STATE_ACTIVE; }
	public function isInactive	() { return $this->state == self::STATE_INACTIVE; }
	public function isBan		() { return $this->state == self::STATE_BAN; }

	public function checkPassword($password)
	{
		return $this->password == self::cryptPassword($password);
	}

	public static function checkUsernameExist($username, $id_exit)
	{
		return self::where('username', '=', $username)
					->whereNotIn('id', array($id_exit))
					->first();
	}

	public static function checkEmailExist($email, $id_exit)
	{
		return self::where('email', '=', $email)
					->whereNotIn('id', array($id_exit))
					->first();
	}

	/**
	 * Display
	 */

	public function displayUsername()
	{
		return '<a href="' . route('admin_user_edit', array('id' => $this->id)) . '" title="Editer l\'utilisateur ' . Tools::stringBoldRemove($this->username) . '" data-toggle="tooltip">' . $this->username . '</a>';
	}

	public function displayStateLabel()
	{
		if ($this->isBan()) return '&nbsp;<span class="label label-danger">Banni</span>&nbsp;';

		return '';
	}

	public function displayCreatedAt()
	{
		return date('d/m/Y', strtotime($this->created_at));
	}

	public function displayState()
	{
		return $this->isActive()?	'<a class="actions" href="' . route('admin_user_state', array('id' => $this->id, 'state' => self::STATE_INACTIVE))	. '" title="Désactiver l\'utilisateur '	. $this->username . '" data-toggle="tooltip">' . HTML::image('images/icons/online.png')		. '</a>':
									'<a class="actions" href="' . route('admin_user_state', array('id' => $this->id, 'state' => self::STATE_ACTIVE))	. '" title="Activer l\'utilisateur '		. $this->username . '" data-toggle="tooltip">' . HTML::image('images/icons/offline.png')	. '</a>';
	}

	public function displayEdit()
	{
		return '<a class="actions" href="' . route('admin_user_edit', array('id' => $this->id)) . '" title="Editer l\'utilisateur ' . $this->username . '" data-toggle="tooltip">' . HTML::image('images/icons/edit.png') . '</a>';
	}

	public function displayDelete()
	{
		return '<a class="actions delete" href="' . route('admin_user_delete', array('id' => $this->id)) . '" title="Supprimer l\'utilisateur ' . $this->username . '" data-toggle="tooltip">' . HTML::image('images/icons/delete.png') . '</a>';
	}

	public function displayActions()
	{
		return $this->displayState() . '&nbsp;&nbsp;&nbsp;' . $this->displayEdit() . '&nbsp;&nbsp;&nbsp;' . $this->displayDelete();
	}

	public function displayAdminUsername()
	{
		return HTML::link(route('admin_administrator_edit', array('id' => $this->id)), $this->username, array('title' => 'Editer l\'administrateur ' . $this->username, 'data-toggle' => 'tooltip'));
	}

	public function displayAdminState()
	{
		return $this->isActive()?	'<a class="actions" href="' . route('admin_administrator_state', array('id' => $this->id, 'state' => self::STATE_INACTIVE))	. '" title="Désactiver l\'administrateur '	. $this->username . '" data-toggle="tooltip">' . HTML::image('images/icons/online.png')		. '</a>':
									'<a class="actions" href="' . route('admin_administrator_state', array('id' => $this->id, 'state' => self::STATE_ACTIVE))	. '" title="Activer l\'administrateur '		. $this->username . '" data-toggle="tooltip">' . HTML::image('images/icons/offline.png')	. '</a>';
	}

	public function displayAdminEdit()
	{
		return '<a class="actions" href="' . route('admin_administrator_edit', array('id' => $this->id)) . '" title="Editer l\'administrateur ' . $this->username . '" data-toggle="tooltip">' . HTML::image('images/icons/edit.png') . '</a>';
	}

	public function displayAdminDelete()
	{
		return '<a class="actions delete" href="' . route('admin_administrator_delete', array('id' => $this->id)) . '" title="Supprimer l\'administrateur ' . $this->username . '" data-toggle="tooltip">' . HTML::image('images/icons/delete.png') . '</a>';
	}

	public function displayAdminActions()
	{
		return $this->displayAdminState() . '&nbsp;&nbsp;&nbsp;' . $this->displayAdminEdit() . '&nbsp;&nbsp;&nbsp;' . $this->displayAdminDelete();
	}
}