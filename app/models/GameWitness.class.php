<?php

class GameWitness extends Eloquent
{
	const STATE_VALIDATED	= 1;
	const STATE_WAITING		= 2;

	protected $table = 'game_witness';

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

	/**
	 * Specify
	 */

	public static function byId($id, $is_fail = false)
	{
		return $is_fail? self::findOrFail($id): self::find($id);
	}

	/**
	 * Joins
	 */

	public function user()
	{
		return $this->belongsTo('User', 'user_id');
	}

	public function game()
	{
		return $this->belongsTo('Game', 'game_id');
	}

	/**
	 * Check
	 */

	public function isValidated	() { return $this->state == self::STATE_VALIDATED; }
	public function isWaiting	() { return $this->state == self::STATE_WAITING; }

	/**
	 * Display
	 */

	public function displayUser()
	{
		return HTML::link(route('admin_user_edit', array('id' => $this->user->id)), $this->user->username, array('title' => 'Editer l\'utilisateur ' . $this->user->username, 'data-toggle' => 'tooltip'));
	}

	public function displayGame()
	{
		return HTML::link(route('admin_game_edit', array('id' => $this->game->id)), $this->game->title, array('title' => 'Editer le jeu ' . $this->game->title, 'data-toggle' => 'tooltip'));
	}

	public function displayStateLabel()
	{
		if ($this->isWaiting()) return '&nbsp;<span class="label label-warning">En attente de validation</span>&nbsp;';

		return '';
	}

	public function displayStar()
	{
		$str = '';

		for ($i = 1; $i <= 5; $i++) $str .= '<i class="glyphicon glyphicon-star'. ($i > $this->star? '-empty': '') .'"></i> ';

		return $str;
	}

	public function displayCreatedAt()
	{
		return date('d/m/Y', strtotime($this->created_at));
	}

	public function displayEdit()
	{
		return '<a class="actions" href="' . route('admin_witness_edit', array('id' => $this->id)) . '" title="Editer le témoignage de ' . $this->user->username . '" data-toggle="tooltip">' . HTML::image('images/icons/edit.png') . '</a>';
	}

	public function displayDelete()
	{
		return '<a class="actions delete" href="' . route('admin_witness_delete', array('id' => $this->id)) . '" title="Supprimer le témoignage de ' . $this->user->username . '" data-toggle="tooltip">' . HTML::image('images/icons/delete.png') . '</a>';
	}

	public function displayActions()
	{
		return $this->displayEdit() . '&nbsp;&nbsp;&nbsp;' . $this->displayDelete();
	}
}