<?php namespace App\Services\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class UserAchievementValidator
{
    public static function api()
    {
        return Validator::make(
            Input::all(),
            array(
                'score' => array('required', 'numeric')
            ),
            array(
                'score.required'=> 'Le score est obligatoire.',
                'score.numeric' => 'Le score doit être un nombre.',
            ));
    }
}