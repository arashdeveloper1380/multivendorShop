<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warranty extends Model
{
    use SoftDeletes;

    protected $table = "warranties";

    protected $fillable = ['id','name'];

    public static function getData($request)
    {
        $string = '?';
        $Warranty = self::latest();

        if(inTrashed($request)){
            $Warranty = $Warranty->onlyTrashed();
            $string = create_paginate_url($string,'trashed=true');
        }

        if(array_key_exists('string',$request) && !empty($request['string'])){
            $Warranty = $Warranty->where('name','like','%'.$request['string'].'%');
            $string = create_paginate_url($string,'string='.$request['string']);
        }

        $Warranty = $Warranty->orderBy('created_at','DESC')->paginate(5);
        $Warranty->withPath($string);

        return $Warranty;
    }

}
