<?php

class Game extends Eloquent
{
	const STATE_ACTIVE	= 1;
	const STATE_INACTIVE= 2;

	protected $table = 'game';

	/**
	 * Magic methods
	 */

	public function __construct()
	{
		$this->reference= Tools::generateUniqId();
		$this->datas	= json_encode(array('pos' => array('x' => 0, 'y' => 0)));
		$this->setStateInactive();
	}

	/**
	 * Global
	 */

	public static function allList()
	{
		return self::orderBy('created_at', 'desc')
					->where('is_main', false)
					->get();
	}

	public static function research($research)
	{
		$games = self::where(function($q) use ($research)
					{
						$q->where('reference',		'like', '%' . $research . '%')
							->orWhere('title',		'like', '%' . $research . '%')
							->orWhere('description','like', '%' . $research . '%');
					})
					->get();

		foreach ($games as $game)
		{
			$game->reference	= Tools::stringBold($research, $game->reference);
			$game->title		= Tools::stringBold($research, $game->title);
			$game->description	= Tools::stringBold($research, $game->description);
		}

		return $games;
	}

	/**
	 * Specify
	 */

	public static function byId($id, $is_fail = false)
	{
		return $is_fail? self::findOrFail($id): self::find($id);
	}

	public static function byReference($reference)
	{
		return self::where('reference', $reference)->first();
	}

	public static function byReferenceActive($reference)
	{
		return self::where('reference',	$reference)
					->where('state',	self::STATE_ACTIVE)
					->first();
	}

	public static function byTitle($title, $is_fail = false)
	{
		$q = self::where('title', $title);

		return $is_fail? $q->firstOrFail(): $q->first();
	}

	public static function main()
	{
		return self::where('is_main', true)->first();
	}

	/**
	 * Joins
	 */

	public function image()
	{
		return $this->belongsTo('Image', 'image_id');
	}

	public function gameUsers()
	{
		return $this->hasMany('GameUser', 'game_id');
	}

	public function witnesses()
	{
		return $this->hasMany('GameWitness', 'game_id');
	}

	/**
	 * Overrides
	 */

	public function delete()
	{
		$image		= $this->image;
		$game_users	= $this->gameUsers;
		$witnesses	= $this->witnesses;

		foreach ($game_users	as $game_user)	$game_user	->delete();
		foreach ($witnesses		as $witness)	$witness	->delete();

		parent::delete();

		$image->delete();
	}

	/**
	 * Setters
	 */

	public function setImage()
	{
		if (!Input::hasFile('image')) return;

		if ($this->image_id) $image = $this->image;
		else
		{
			$image = new Image;
			$image->setTypeGame();
		}

		$image->setOwner($this);
		$image->upload('image', false);
	}

	public function setStateActive	() { $this->state = self::STATE_ACTIVE; }
	public function setStateInactive() { $this->state = self::STATE_INACTIVE; }

	/**
	 * Check
	 */

	public function isActive	() { return $this->state == self::STATE_ACTIVE; }
	public function isInactive	() { return $this->state == self::STATE_INACTIVE; }

	public function isMain() { return $this->is_main; }

	public static function checkTitleExist($title, $id_exit)
	{
		return self::where('title', '=', $title)
					->whereNotIn('id', array($id_exit))
					->first();
	}

	/**
	 * Display
	 */

	public function displayTitle()
	{
		return HTML::link(route('admin_game_edit', array('id' => $this->id)), $this->title, array('title' => 'Editer le jeu ' . $this->title, 'data-toggle' => 'tooltip'));
	}

	public function displayCreatedAt()
	{
		return date('d/m/Y', strtotime($this->created_at));
	}

	public function displayState()
	{
		return $this->isActive()?	'<a class="actions" href="' . route('admin_game_state', array('id' => $this->id, 'state' => self::STATE_INACTIVE))	. '" title="Désactiver le jeu '	. $this->title . '" data-toggle="tooltip">' . HTML::image('images/icons/online.png')		. '</a>':
									'<a class="actions" href="' . route('admin_game_state', array('id' => $this->id, 'state' => self::STATE_ACTIVE))	. '" title="Activer le jeu '	. $this->title . '" data-toggle="tooltip">' . HTML::image('images/icons/offline.png')	. '</a>';
	}

	public function displayEdit()
	{
		return '<a class="actions" href="' . route('admin_game_edit', array('id' => $this->id)) . '" title="Editer le jeu ' . $this->title . '" data-toggle="tooltip">' . HTML::image('images/icons/edit.png') . '</a>';
	}

	public function displayDelete()
	{
		return '<a class="actions delete" href="' . route('admin_game_delete', array('id' => $this->id)) . '" title="Supprimer le jeu ' . $this->title . '" data-toggle="tooltip">' . HTML::image('images/icons/delete.png') . '</a>';
	}

	public function displayActions()
	{
		return $this->displayState() . '&nbsp;&nbsp;&nbsp;' . $this->displayEdit() . '&nbsp;&nbsp;&nbsp;' . $this->displayDelete();
	}
}