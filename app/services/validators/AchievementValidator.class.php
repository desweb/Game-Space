<?php namespace App\Services\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class AchievementValidator
{
    public static function adminAdd()
    {
        return Validator::make(
            Input::all(),
            array(
                'image'			=> array('required', 'mimes:jpeg,png', 'max:1024'),
                'title'      	=> array('required'),
                'score'         => array('required', 'numeric'),
                'description'   => array('required')
            ),
            array(
                'image.required'		=> 'L\'avatar est obligatoire.',
                'image.mimes'   		=> 'L\'avatar doit être au format JPEG ou PNG.',
                'image.size'    		=> 'L\'avatar ne doit pas dépasser 1Mo.',
                'title.required'     	=> 'Le titre est obligatoire.',
                'score.required'        => 'Le score est obligatoire.',
                'score.numeric'         => 'Le score doit être un nombre.',
                'description.required'  => 'La phrase d\'accroche est obligatoire.'
            ));
    }

    public static function adminEdit()
    {
        return Validator::make(
            Input::all(),
            array(
                'title'      	=> array('required'),
                'score'         => array('required', 'numeric'),
                'description'   => array('required')
            ),
            array(
                'title.required'     	=> 'Le titre est obligatoire.',
                'score.required'        => 'Le score est obligatoire.',
                'score.numeric'         => 'Le score doit être un nombre.',
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