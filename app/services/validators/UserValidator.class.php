<?php namespace App\Services\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class UserValidator
{
    public static function adminAdd()
    {
        return Validator::make(
            Input::all(),
            array(
                'photo'			=> array('required', 'mimes:jpeg,png', 'max:1024'),
                'username'      => array('required'),
                'email'         => array('required', 'email'),
                'birthday_at'   => array('required', 'regex:/^([0-9]{2}\/){2}[0-9]{4}$/')
            ),
            array(
                'photo.required'		=> 'L\'avatar est obligatoire.',
                'photo.mimes'   		=> 'L\'avatar doit être au format JPEG ou PNG.',
                'photo.size'    		=> 'L\'avatar ne doit pas dépasser 1Mo.',
                'username.required'     => 'Le pseudo est obligatoire.',
                'email.required'        => 'L\'email est obligatoire.',
                'email.email'           => 'L\'email est invalide.',
                'birthday_at.required'  => 'La date de naissance est obligatoire.',
                'birthday_at.regex'     => 'La date de naissance est invalide.'
            ));
    }

    public static function adminEdit()
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

    public static function apiAdd()
    {
        return Validator::make(
            Input::all(),
            array(
                'photo'         => array('required', 'mimes:jpeg,png', 'max:1024'),
                'username'      => array('required'),
                'email'         => array('required', 'email'),
                'password'      => array('required', 'regex:/^[0-9a-f]{32}$/'),
                'birthday_time' => array('required', 'numeric'),
                'time'          => array('required', 'numeric')
            ),
            array(
                'photo.required'        => 'L\'avatar est obligatoire.',
                'photo.mimes'           => 'L\'avatar doit être au format JPEG ou PNG.',
                'photo.size'            => 'L\'avatar ne doit pas dépasser 1Mo.',
                'username.required'     => 'Le pseudo est obligatoire.',
                'email.required'        => 'L\'email est obligatoire.',
                'email.email'           => 'L\'email est invalide.',
                'password.required'     => 'Le mot de passe est obligatoire.',
                'password.regex'        => 'Le mot de passe est incorrect.',
                'birthday_time.required'=> 'La date de naissance est obligatoire.',
                'birthday_time.numeric' => 'La date de naissance est invalide.',
                'time.required'         => 'Le timestamp est obligatoire.',
                'time.numeric'          => 'Le timestamp est invalide.'
            ));
    }

    public static function apiEdit()
    {
        return Validator::make(
            Input::all(),
            array(
                'username'      => array('required'),
                'email'         => array('required', 'email'),
                'birthday_time' => array('required', 'numeric')
            ),
            array(
                'username.required'     => 'Le pseudo est obligatoire.',
                'email.required'        => 'L\'email est obligatoire.',
                'email.email'           => 'L\'email est invalide.',
                'birthday_time.required'=> 'La date de naissance est obligatoire.',
                'birthday_time.numeric' => 'La date de naissance est invalide.'
            ));
    }

    public static function apiPhoto()
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

    public static function apiPassword()
    {
        return Validator::make(
            Input::all(),
            array(
                'old_password'  => array('required', 'regex:/^[0-9a-f]{32}$/'),
                'password'      => array('required', 'regex:/^[0-9a-f]{32}$/')
            ),
            array(
                'old_password.required' => 'Le mot de passe est obligatoire.',
                'old_password.regex'    => 'Le mot de passe est invalide.',
                'password.required'     => 'Le nouveau mot de passe est obligatoire.',
                'password.regex'        => 'Le nouveau mot de passe est invalide.'
            ));
    }
}