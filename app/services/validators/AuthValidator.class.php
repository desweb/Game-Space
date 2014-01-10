<?php namespace App\Services\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class AuthValidator
{
    public static function connexion()
    {
        return Validator::make(
            Input::all(),
            array(
                'email'     => array('required', 'email'),
                'password'  => array('required', 'min:8')
            ),
            array(
                'email.required'    => 'L\'email est obligatoire.',
                'email.email'       => 'Email invalide.',
                'password.required' => 'Le mot de passe est obligatoire.',
                'password.min'      => 'Logs incorrects.'
            ));
    }

    public static function lostPassword()
    {
        return Validator::make(
            Input::all(),
            array(
                'email' => array('required', 'email')
            ),
            array(
                'email.required'=> 'L\'email est obligatoire.',
                'email.email'   => 'Email invalide.'
            ));
    }

    public static function recoverPassword()
    {
        return Validator::make(
            Input::all(),
            array(
                'password'          => array('required', 'min:8'),
                'password_confirm'  => array('required', 'same:password')
            ),
            array(
                'password.required'         => 'Le mot de passe est obligatoire.',
                'password.min'              => 'Le mot de passe doit faire au minimum :min caractères.',
                'password_confirm.required' => 'La confirmation du mot de passe est obligatoire.',
                'password_confirm.same'     => 'Mauvaise confirmation du mot de passe.'
            ));
    }
}