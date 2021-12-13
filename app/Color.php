<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use SoftDeletes;

    protected $table = "colors";

    protected $fillable = [
        'id','name','code'
    ];

    public static function getData($request){
        $string = '?';
        $Color = self::latest();
        if(inTrashed($request)){
            $Color=$Color->onlyTrashed();
            $string = create_paginate_url($string,'trashed=true');
        }

        if(array_key_exists('string',$request) && !empty($request['string'])){
            $Color = $Color->where('name','like','%'.$request['string'].'%');
            $Color = $Color->orWhere('code','like','%'.$request['string'].'%');
            $string = create_paginate_url($string,'string='.$request['string']);
        }

        $Color = $Color->orderBy('created_at','DESC')->paginate(5);
        $Color->withPath($string);
        return $Color;
    }
}
