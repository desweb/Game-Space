<?php namespace App\Services\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class GameUserValidator
{
    public static function apiUpdate()
    {
        return Validator::make(
            Input::all(),
            array(
                'level' => array('required', 'numeric'),
                'score' => array('required', 'numeric')
            ),
            array(
                'level.required'=> 'Le niveau est obligatoire.',
                'level.numeric' => 'Le niveau doit être un nombre.',
                'score.required'=> 'Le niveau est obligatoire.',
                'score.numeric' => 'Le niveau doit être un nombre.',
            ));
    }
}