<?php namespace App\Services\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class ContactValidator
{
    public static function adminAnswer()
    {
        return Validator::make(
            Input::all(),
            array(
                'answer' => array('required')
            ),
            array(
                'answer.required' => 'Le message est obligatoire.'
            ));
    }
}