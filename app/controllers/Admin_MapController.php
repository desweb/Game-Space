<?php

use App\Services\Validators\MapValidator;

class Admin_MapController extends BaseController
{
	public function index()
	{
		return View::make('admin.map.index')->with('maps', Map::allList());
	}

	public function add()
	{
		return View::make('admin.map.manage');
	}

	public function edit($id)
	{
		return View::make('admin.map.manage')->with('map', Map::byIdOrFail($id));
	}

	public function delete($id)
	{
		$map = Map::byIdOrFail($id);

		$title = $map->title;

		$map->delete();

		return Redirect::route('admin_map')->with('message_success', 'Carte <b>' . $title . '</b> supprimée.');
	}

	public function main()
	{
		return View::make('admin.map.manageMain');
	}
}