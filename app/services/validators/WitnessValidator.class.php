<?php namespace App\Services\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class WitnessValidator
{
    public static function adminEdit()
    {
        return Validator::make(
            Input::all(),
            array(
                'message' => array('required')
            ),
            array(
                'message.required' => 'Le témoignage est obligatoire.'
            ));
    }

    public static function api()
    {
        return Validator::make(
            Input::all(),
            array(
                'star'      => array('required', 'numeric'),
                'message'   => array('required')
            ),
            array(
                'star.required'     => 'La note est obligatoire.',
                'star.numeric'      => 'La note doit être un nombre.',
                'message.required'  => 'Le témoignage est obligatoire.'
            ));
    }
}