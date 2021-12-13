<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use SoftDeletes;

    protected $table = "sliders";

    protected $fillable = ['title','url','imageUrl','mobile_image_url'];

    public static function getData($request){
        $string = '?';
        $Slider = self::latest();
        if(inTrashed($request)){
            $Slider=$Slider->onlyTrashed();
            $string = create_paginate_url($string,'trashed=true');
        }

        if(array_key_exists('string',$request) && !empty($request['string'])){
            $Slider = $Slider->where('title','like','%'.$request['string'].'%');
            $string = create_paginate_url($string,'string='.$request['string']);
        }

        $Slider = $Slider->orderBy('created_at','DESC')->paginate(5);
        $Slider->withPath($string);
        return $Slider;
    }
}
