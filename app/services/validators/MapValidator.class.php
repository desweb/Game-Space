<?php namespace App\Services\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class MapValidator
{
	public static function add()
	{
		return Validator::make(
			Input::all(),
			array(
				'title' => array('required'),
				'datas' => array('required')
			),
			array(
				'title.required' => 'Le titre est obligatoire.',
				'datas.required' => 'Les données de mapping sont obligatoires.'
		));
	}

	public static function edit()
	{
		return Validator::make(
			Input::all(),
			array(
				'title' => array('required'),
				'datas' => array('required')
			),
			array(
				'title.required' => 'Le titre est obligatoire.',
				'datas.required' => 'Les données de mapping sont obligatoires.'
		));
	}
}