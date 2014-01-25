<?php

class Map extends Eloquent
{
	const TILEMAP_PATH = 'http://game-space.desweb-creation.fr/images/tilemap/';

	const TYPE_DESERT = 1;

	protected $table = 'map';

	/**
	 * Global
	 */

	public static function allList()
	{
		return self::orderBy('created_at', 'desc')->get();
	}

	/**
	 * Specify
	 */

	public static function byId($id)
	{
		return self::where('id', $id)->first();
	}

	public static function byIdOrFail($id)
	{
		return self::where('id', $id)->firstOrFail();
	}

	public static function byTitle($title)
	{
		return self::where('title', $title)->first();
	}

	/**
	 * Getters
	 */

	public static function types()
	{
		return array(
			self::TILEMAP_PATH . 'desert.png' => 'Desert');
	}

	/**
	 * Check
	 */

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
		return HTML::link(route('admin_map_edit', array('id' => $this->id)), $this->title, array('target' => '_blank', 'title' => 'Editer la carte ' . $this->title, 'data-toggle' => 'tooltip'));
	}

	public function displayCreatedAt()
	{
		return date('d/m/Y', strtotime($this->created_at));
	}

	public function displayEdit()
	{
		return '<a class="actions" href="' . route('admin_map_edit', array('id' => $this->id)) . '" target="_blank" title="Editer la carte ' . $this->title . '" data-toggle="tooltip">' . HTML::image('images/icons/edit.png') . '</a>';
	}

	public function displayDownload()
	{
		return '<a class="actions" href="' . route('admin_map_download', array('id' => $this->id)) . '" title="Télécharger la carte ' . $this->title . '" data-toggle="tooltip"><i class="glyphicon glyphicon-download"></i></a>';
	}

	public function displayDelete()
	{
		return '<a class="actions delete" href="' . route('admin_map_delete', array('id' => $this->id)) . '" title="Supprimer la carte ' . $this->title . '" data-toggle="tooltip">' . HTML::image('images/icons/delete.png') . '</a>';
	}

	public function displayActions()
	{
		return $this->displayEdit() . '&nbsp;&nbsp;&nbsp;' . $this->displayDownload() . '&nbsp;&nbsp;&nbsp;' . $this->displayDelete();
	}
}