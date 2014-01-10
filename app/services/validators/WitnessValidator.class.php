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
}