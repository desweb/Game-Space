<?php namespace App\Services\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class GameValidator
{
    public static function adminAdd()
    {
        return Validator::make(
            Input::all(),
            array(
                'image'			=> array('required', 'mimes:jpeg,png', 'max:1024'),
                'title'      	=> array('required'),
                'description'   => array('required')
            ),
            array(
                'image.required'		=> 'L\'avatar est obligatoire.',
                'image.mimes'   		=> 'L\'avatar doit être au format JPEG ou PNG.',
                'image.size'    		=> 'L\'avatar ne doit pas dépasser 1Mo.',
                'title.required'     	=> 'Le titre est obligatoire.',
                'description.required'  => 'La phrase d\'accroche est obligatoire.'
            ));
    }

    public static function adminEdit()
    {
        return Validator::make(
            Input::all(),
            array(
                'title'      	=> array('required'),
                'description'   => array('required')
            ),
            array(
                'title.required'     	=> 'Le titre est obligatoire.',
                'description.required'  => 'La phrase d\'accroche est obligatoire.'
            ));
    }

    public static function adminImage()
    {
        return Validator::make(
            Input::all(),
            array(
                'image' => array('required', 'mimes:jpeg,png', 'max:1024')
            ),
            array(
                'image.required'=> 'L\'avatar est obligatoire.',
                'image.mimes'   => 'L\'avatar doit être au format JPEG ou PNG.',
                'image.size'    => 'L\'avatar ne doit pas dépasser 1Mo.'
            ));
    }
}