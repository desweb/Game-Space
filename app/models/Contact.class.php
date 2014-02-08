<?php

class Contact extends Eloquent
{
	const STATE_WAITING	= 1;
	const STATE_READ	= 2;
	const STATE_ANSWERED= 3;

	private static $objects = array(
		1 => 'Objet de message 1',
		2 => 'Objet de message 2',
		3 => 'Objet de message 3');

	protected $table = 'contact';

	/**
	 * Magic methods
	 */

	public function __construct()
	{
		$this->setStateWaiting();
	}

	/**
	 * Global
	 */

	public static function allList()
	{
		return self::orderBy('created_at', 'desc')->get();
	}

	public static function waiting()
	{
		return self::where('state', self::STATE_WAITING);
	}

	public static function research($research)
	{
		$contacts = self::where(function($q) use ($research)
					{
						$q->where('username',	'like', '%' . $research . '%')
							->orWhere('email',	'like', '%' . $research . '%')
							->orWhere('message','like', '%' . $research . '%');
					})
					->get();

		foreach ($contacts as $contact)
		{
			$contact->username	= Tools::stringBold($research, $contact->username);
			$contact->email		= Tools::stringBold($research, $contact->email);
			$contact->message	= Tools::stringBold($research, $contact->message);
		}

		return $contacts;
	}

	/**
	 * Specify
	 */

	public static function byId($id, $is_fail = false)
	{
		return $is_fail? self::findOrFail($id): self::find($id);
	}

	/**
	 * Functionalities
	 */

	public static function objects()
	{
		return self::$objects;
	}

	/**
	 * Getters
	 */

	public function getObject()
	{
		return self::$objects[$this->object];
	}

	/**
	 * Setters
	 */

	public function setStateWaiting	() { $this->state = self::STATE_WAITING; }
	public function setStateRead	() { $this->state = self::STATE_READ; }
	public function setStateAnswered() { $this->state = self::STATE_ANSWERED; }

	/**
	 * Check
	 */

	public function isWaiting	() { return $this->state == self::STATE_WAITING; }
	public function isRead		() { return $this->state == self::STATE_READ; }
	public function isAnswered	() { return $this->state == self::STATE_ANSWERED; }

	/**
	 * Display
	 */

	public function displayReadLabel()
	{
		if		($this->isWaiting())return '&nbsp;<span class="label label-danger">Non lu</span>&nbsp;';
		else if	($this->isRead())	return '&nbsp;<span class="label label-warning">Non répondu</span>&nbsp;';

		return '';
	}

	public function displayCreatedAt()
	{
		return date('d/m/Y', strtotime($this->created_at));
	}

	public function displayShow()
	{
		return '<a class="actions" href="' . route('admin_contact_show', array('id' => $this->id)) . '" title="Voir le message de ' . $this->username . '" data-toggle="tooltip"><i class="glyphicon glyphicon-eye-open"></i></a>';
	}

	public function displayDelete()
	{
		return '<a class="actions delete" href="' . route('admin_contact_delete', array('id' => $this->id)) . '" title="Supprimer le message de ' . $this->username . '" data-toggle="tooltip">' . HTML::image('images/icons/delete.png') . '</a>';
	}

	public function displayActions()
	{
		return $this->displayShow() . '&nbsp;&nbsp;&nbsp;' . $this->displayDelete();
	}
}