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
				'title'			=> array('required'),
				'description'	=> array('required'),
				'datas'			=> array('required')
			),
			array(
				'title.required'		=> 'Le titre est obligatoire.',
				'description.required'	=> 'Le titre est obligatoire.',
				'datas.required'		=> 'Le titre est obligatoire.'
		));
	}

	public static function edit()
	{
		return Validator::make(
			Input::all(),
			array(
				'title'			=> array('required'),
				'description'	=> array('required'),
				'datas'			=> array('required')
			),
			array(
				'title.required'		=> 'Le titre est obligatoire.',
				'description.required'	=> 'Le titre est obligatoire.',
				'datas.required'		=> 'Le titre est obligatoire.'
		));
	}
}