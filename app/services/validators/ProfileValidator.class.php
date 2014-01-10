<?php namespace App\Services\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class ProfileValidator
{
    public static function admin()
    {
        return Validator::make(
            Input::all(),
            array(
                'username'      => array('required'),
                'email'         => array('required', 'email'),
                'birthday_at'   => array('required', 'regex:/^([0-9]{2}\/){2}[0-9]{4}$/')
            ),
            array(
                'username.required'     => 'Le pseudo est obligatoire.',
                'email.required'        => 'L\'email est obligatoire.',
                'email.email'           => 'L\'email est invalide.',
                'birthday_at.required'  => 'La date de naissance est obligatoire.',
                'birthday_at.regex'     => 'La date de naissance est invalide.'
            ));
    }

    public static function adminPhoto()
    {
        return Validator::make(
            Input::all(),
            array(
                'photo' => array('required', 'mimes:jpeg,png', 'max:1024')
            ),
            array(
                'photo.required'=> 'L\'avatar est obligatoire.',
                'photo.mimes'   => 'L\'avatar doit être au format JPEG ou PNG.',
                'photo.size'    => 'L\'avatar ne doit pas dépasser 1Mo.'
            ));
    }

    public static function adminPassword()
    {
        return Validator::make(
            Input::all(),
            array(
                'old_password'      => array('required', 'min:8'),
                'password'          => array('required', 'min:8'),
                'password_confirm'  => array('same:password')
            ),
            array(
                'old_password.required' => 'Le mot de passe est obligatoire.',
                'old_password.min'      => 'Le mot de passe doit faire au minimum 8 caractères.',
                'password.required'     => 'Le nouveau mot de passe est obligatoire.',
                'password.min'          => 'Le nouveau mot de passe doit faire au minimum 8 caractères.',
                'password_confirm.same' => 'Mauvaise confirmation du nouveau mot de passe.'
            ));
    }
}