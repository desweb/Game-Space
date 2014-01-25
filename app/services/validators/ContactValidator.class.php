<?php namespace App\Services\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class ContactValidator
{
    public static function apiAdd()
    {
        return Validator::make(
            Input::all(),
            array(
                'username'  => array('required'),
                'email'     => array('required', 'email'),
                'object'    => array('required', 'numeric'),
                'message'   => array('required')
            ),
            array(
                'username.required' => 'Le pseudo est obligatoire.',
                'email.required'    => 'L\'email est obligatoire.',
                'email.email'       => 'L\'email est invalide.',
                'object.required'   => 'L\'objet est obligatoire.',
                'object.numeric'    => 'L\'objet est invalide.',
                'message.required'  => 'Le pseudo est obligatoire.'
            ));
    }

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